<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    private const BLANK_PNG_DATA_URI = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO9WlWcAAAAASUVORK5CYII=';

    public function loginPage()
    {
        if (Session::get('admin_logged_in')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
        }

        Session::put('admin_logged_in', true);
        Session::put('admin_username', $admin->username);

        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        Session::forget(['admin_logged_in', 'admin_username']);
        return redirect('/login');
    }

    public function dashboard()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect('/login');
        }
        return view('admin.dashboard');
    }

    public function getInstansi(Request $request)
    {
        $query = Tamu::where('status', 'instansi');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('instansi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('letter')) {
            $query->where('nama', 'like', $request->letter . '%');
        }

        if ($request->filled('sort')) {
            $sortVal = $request->sort;
            if (in_array($sortVal, ['asc', 'desc'])) {
                $query->orderBy('nama', $sortVal);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $instansiList = $query->get();
        $count = $instansiList->count();

        return response()->json([
            'count' => $count,
            'data' => $instansiList->map(function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'db_id' => $item->id,
                    'nama' => $item->nama,
                    'status' => $item->status,
                    'instansi' => $item->instansi ?? '-',
                    'ulasan' => $item->ulasan ?? 'senang',
                    'foto' => $item->foto,
                    'tanda_tangan' => $item->tanda_tangan,
                ];
            })->values()
        ]);
    }

    public function getSekolah(Request $request)
    {
        $query = Tamu::where('status', 'sekolah');

        if ($request->filled('search_nama') || $request->filled('search')) {
            $term = $request->search_nama ?: $request->search;
            $query->where('nama', 'like', '%' . $term . '%');
        }

        if ($request->filled('search_sekolah') || $request->filled('search_kelas')) {
            $school = $request->search_sekolah ?: $request->search_kelas;
            $query->where('asal_sekolah', 'like', '%' . $school . '%');
        }

        if ($request->filled('letter')) {
            $query->where('nama', 'like', $request->letter . '%');
        }

        if ($request->filled('sort')) {
            $sortVal = $request->sort;
            if (in_array($sortVal, ['asc', 'desc'])) {
                $query->orderBy('nama', $sortVal);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $schools = $query->get();
        $count = $schools->count();

        return response()->json([
            'count' => $count,
            'data' => $schools->map(function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'db_id' => $item->id,
                    'nama' => $item->nama,
                    'asal_sekolah' => $item->asal_sekolah ?? '-',
                    'status' => $item->status,
                    'ulasan' => $item->ulasan ?? 'senang',
                    'foto' => $item->foto,
                    'tanda_tangan' => $item->tanda_tangan,
                ];
            })->values()
        ]);
    }

    public function getSchoolsList()
    {
        $schools = Tamu::where('status', 'sekolah')
            ->whereNotNull('asal_sekolah')
            ->where('asal_sekolah', '!=', '')
            ->distinct()
            ->pluck('asal_sekolah')
            ->sort()
            ->values();

        return response()->json($schools);
    }

    public function getTeachers(Request $request)
    {
        return $this->getInstansi($request);
    }

    public function getStudents(Request $request)
    {
        return $this->getSekolah($request);
    }

    public function getClasses()
    {
        return $this->getSchoolsList();
    }

    public function getData($id)
    {
        $data = Tamu::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'status' => 'required|in:instansi,sekolah,guru,siswa',
            'instansi' => 'nullable|string|max:150',
            'asal_sekolah' => 'nullable|string|max:150',
            'ulasan' => 'nullable|in:senang,menarik,unik,biasa,sedih',
        ]);

        $status = in_array($request->status, ['instansi', 'sekolah'])
            ? $request->status
            : ($request->status === 'guru' ? 'instansi' : 'sekolah');

        $tamu->update([
            'nama' => $request->nama,
            'status' => $status,
            'instansi' => $status === 'instansi' ? ($request->instansi ?? $request->kelas) : null,
            'asal_sekolah' => $status === 'sekolah' ? ($request->asal_sekolah ?? $request->kelas) : null,
            'ulasan' => $request->ulasan ?? $tamu->ulasan ?? 'senang',
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }

    public function deleteData($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function exportPdf(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect('/login');
        }

        @set_time_limit(180);
        @ini_set('memory_limit', '256M');

        $section = $request->get('section', 'instansi');
        $isSchool = in_array($section, ['sekolah', 'student', 'school']);

        $query = Tamu::query()->where('status', $isSchool ? 'sekolah' : 'instansi');

        if ($isSchool) {
            if ($request->filled('search_nama') || $request->filled('search')) {
                $query->where('nama', 'like', '%' . ($request->search_nama ?: $request->search) . '%');
            }
            if ($request->filled('search_sekolah') || $request->filled('search_kelas')) {
                $query->where('asal_sekolah', 'like', '%' . ($request->search_sekolah ?: $request->search_kelas) . '%');
            }
        } else {
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%')
                      ->orWhere('instansi', 'like', '%' . $request->search . '%');
                });
            }
        }

        if ($request->filled('letter')) {
            $query->where('nama', 'like', $request->letter . '%');
        }

        if ($request->filled('sort')) {
            $sortVal = $request->sort;
            if (in_array($sortVal, ['asc', 'desc'])) {
                $query->orderBy('nama', $sortVal);
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $items = $query->get(['id', 'nama', 'instansi', 'asal_sekolah', 'status', 'ulasan', 'foto', 'tanda_tangan']);

        $rows = $items->values()->map(function ($item, $index) {
            $signaturePath = ($item->tanda_tangan ?? '') !== '' ? $item->tanda_tangan : null;

            return [
                'no' => $index + 1,
                'nama' => $item->nama,
                'instansi' => $item->instansi ?? '-',
                'asal_sekolah' => $item->asal_sekolah ?? '-',
                'ulasan' => $item->ulasan ?? 'senang',
                'status' => $item->status,
                'foto_data_uri' => $this->imageToDataUri(($item->foto ?? '') !== '' ? $item->foto : null, 220, 165, 68),
                'ttd_data_uri' => $signaturePath ? $this->imageToDataUri($signaturePath, 220, 100, 78) : self::BLANK_PNG_DATA_URI,
            ];
        });

        $schoolFilter = $isSchool ? trim((string) ($request->get('search_sekolah', $request->get('search_kelas', '')))) : '';
        $sectionLabel = $isSchool
            ? 'SEKOLAH' . ($schoolFilter !== '' ? ' ' . strtoupper($schoolFilter) : '')
            : 'INSTANSI';

        $pdf = Pdf::loadView('admin.export-pdf', [
            'title' => 'DAFTAR KEHADIRAN PENGUNJUNG',
            'section' => $section,
            'isSchool' => $isSchool,
            'sectionLabel' => $sectionLabel,
            'rows' => $rows,
            'generatedAt' => now(),
            'blankPng' => self::BLANK_PNG_DATA_URI,
        ])
        ->setPaper('a4', 'landscape')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true);

        $filename = $isSchool ? 'daftar-kehadiran-sekolah.pdf' : 'daftar-kehadiran-instansi.pdf';

        return $pdf->download($filename);
    }

    private function imageToDataUri(?string $relativePath, int $maxWidth, int $maxHeight, int $quality): string
    {
        if (!$relativePath) {
            return self::BLANK_PNG_DATA_URI;
        }

        // Clean any leading slash or redundant 'public/' / 'storage/' prefix
        $cleanPath = ltrim($relativePath, '/\\');
        $cleanPath = preg_replace('#^(public/|storage/)+#i', '', $cleanPath);

        // Candidate paths for both local and shared hosting (with or without storage symlink)
        $candidates = [
            storage_path('app/public/' . $cleanPath),
            public_path('storage/' . $cleanPath),
            public_path($cleanPath),
            base_path('storage/app/public/' . $cleanPath),
            base_path('public/storage/' . $cleanPath),
            base_path('public_html/storage/' . $cleanPath),
            base_path('public_html/' . $cleanPath),
        ];

        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/storage/' . $cleanPath;
            $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/' . $cleanPath;
        }

        $fullPath = null;
        foreach ($candidates as $candidate) {
            if ($candidate && @is_file($candidate)) {
                $fullPath = $candidate;
                break;
            }
        }

        if (!$fullPath) {
            return self::BLANK_PNG_DATA_URI;
        }

        // 1. Try GD optimization for high quality & tiny PDF size
        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            $optimized = $this->optimizedImageDataUri($fullPath, $maxWidth, $maxHeight, $quality);
            if ($optimized !== null) {
                return $optimized;
            }
        }

        // 2. Fallback: Raw image data URI (supports up to 4MB)
        if (@filesize($fullPath) <= 4 * 1024 * 1024) {
            return $this->rawImageDataUri($fullPath);
        }

        return self::BLANK_PNG_DATA_URI;
    }

    private function optimizedImageDataUri(string $fullPath, int $maxWidth, int $maxHeight, int $quality): ?string
    {
        $contents = @file_get_contents($fullPath);
        if ($contents === false) {
            return null;
        }

        $source = @imagecreatefromstring($contents);
        if (!$source) {
            return null;
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        if ($sourceWidth <= 0 || $sourceHeight <= 0) {
            imagedestroy($source);
            return null;
        }

        $scale = min($maxWidth / $sourceWidth, $maxHeight / $sourceHeight, 1);
        $targetWidth = max(1, (int) floor($sourceWidth * $scale));
        $targetHeight = max(1, (int) floor($sourceHeight * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);
        $white = imagecolorallocate($target, 255, 255, 255);
        imagefilledrectangle($target, 0, 0, $targetWidth, $targetHeight, $white);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

        ob_start();
        imagejpeg($target, null, $quality);
        $jpeg = ob_get_clean();

        imagedestroy($source);
        imagedestroy($target);

        if ($jpeg === false || $jpeg === '') {
            return null;
        }

        return 'data:image/jpeg;base64,' . base64_encode($jpeg);
    }

    private function rawImageDataUri(string $fullPath): string
    {
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            default => 'image/png',
        };

        $data = @file_get_contents($fullPath);
        if ($data === false) {
            return self::BLANK_PNG_DATA_URI;
        }

        return "data:$mime;base64," . base64_encode($data);
    }
}
