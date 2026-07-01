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

    public function getTeachers(Request $request)
    {
        $query = Tamu::where('status', 'guru');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('letter')) {
            $query->where('nama', 'like', $request->letter . '%');
        }

        if ($request->filled('sort')) {
            $sortVal = $request->sort;
            if (in_array($sortVal, ['asc', 'desc'])) {
                $query->orderBy('nama', $sortVal);
            }
        }

        $teachers = $query->get();
        $count = $teachers->count();

        return response()->json([
            'count' => $count,
            'data' => $teachers->map(function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'db_id' => $item->id,
                    'nama' => $item->nama,
                    'status' => $item->status,
                    'kelas' => $item->kelas,
                    'foto' => $item->foto,
                    'tanda_tangan' => $item->tanda_tangan,
                ];
            })->values()
        ]);
    }

    public function getStudents(Request $request)
    {
        $query = Tamu::where('status', 'siswa');

        if ($request->filled('search_nama')) {
            $query->where('nama', 'like', '%' . $request->search_nama . '%');
        }

        if ($request->filled('search_kelas')) {
            $query->where('kelas', 'like', '%' . $request->search_kelas . '%');
        }

        if ($request->filled('letter')) {
            $query->where('nama', 'like', $request->letter . '%');
        }

        if ($request->filled('sort')) {
            $sortVal = $request->sort;
            if (in_array($sortVal, ['asc', 'desc'])) {
                $query->orderBy('nama', $sortVal);
            }
        }

        $students = $query->get();
        $count = $students->count();

        return response()->json([
            'count' => $count,
            'data' => $students->map(function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'db_id' => $item->id,
                    'nama' => $item->nama,
                    'kelas' => $item->kelas,
                    'status' => $item->status,
                    'foto' => $item->foto,
                    'tanda_tangan' => $item->tanda_tangan,
                ];
            })->values()
        ]);
    }

    public function getClasses()
    {
        $classes = Tamu::where('status', 'siswa')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->pluck('kelas')
            ->sort()
            ->values();

        return response()->json($classes);
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
            'status' => 'required|in:guru,siswa',
            'kelas' => 'nullable|string|max:50',
        ]);

        $tamu->update([
            'nama' => $request->nama,
            'status' => $request->status,
            'kelas' => $request->status === 'guru' ? null : $request->kelas,
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

        @set_time_limit(120);

        $section = $request->get('section', 'teacher');
        $isStudent = $section === 'student';

        $query = Tamu::query()->where('status', $isStudent ? 'siswa' : 'guru');

        if ($isStudent) {
            if ($request->filled('search_nama')) {
                $query->where('nama', 'like', '%' . $request->search_nama . '%');
            }
            if ($request->filled('search_kelas')) {
                $query->where('kelas', 'like', '%' . $request->search_kelas . '%');
            }
        } else {
            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
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

        $items = $query->get(['id', 'nama', 'kelas', 'status', 'foto', 'tanda_tangan']);

        $rows = $items->values()->map(function ($item, $index) {
            $signaturePath = ($item->tanda_tangan ?? '') !== '' ? $item->tanda_tangan : null;

            return [
                'no' => $index + 1,
                'nama' => $item->nama,
                'kelas' => $item->kelas,
                'status' => $item->status,
                'foto_data_uri' => $this->imageToDataUri(($item->foto ?? '') !== '' ? $item->foto : null, 220, 165, 68),
                'ttd_data_uri' => $signaturePath ? $this->imageToDataUri($signaturePath, 220, 100, 78) : self::BLANK_PNG_DATA_URI,
            ];
        });

        $classFilter = $isStudent ? trim((string) $request->get('search_kelas', '')) : '';
        $sectionLabel = $isStudent
            ? 'SISWA' . ($classFilter !== '' ? ' ' . strtoupper($classFilter) : '')
            : 'GURU';

        $pdf = Pdf::loadView('admin.export-pdf', [
            'title' => 'DAFTAR KEHADIRAN',
            'section' => $section,
            'sectionLabel' => $sectionLabel,
            'rows' => $rows,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        if ($isStudent) {
            $classSlug = $classFilter !== ''
                ? '-' . str($classFilter)->lower()->replaceMatches('/[^a-z0-9]+/', '-')->trim('-')
                : '';
            $filename = 'daftar-kehadiran-siswa' . $classSlug . '.pdf';
        } else {
            $filename = 'daftar-kehadiran-guru.pdf';
        }

        return $pdf->download($filename);
    }

    private function imageToDataUri(?string $relativePath, int $maxWidth, int $maxHeight, int $quality): string
    {
        if (!$relativePath) {
            return self::BLANK_PNG_DATA_URI;
        }

        $basePath = realpath(storage_path('app/public'));
        $fullPath = realpath(storage_path('app/public/' . ltrim($relativePath, '/\\')));

        if (!$basePath || !$fullPath || !str_starts_with($fullPath, $basePath) || !is_file($fullPath)) {
            return self::BLANK_PNG_DATA_URI;
        }

        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            $optimized = $this->optimizedImageDataUri($fullPath, $maxWidth, $maxHeight, $quality);
            if ($optimized !== null) {
                return $optimized;
            }
        }

        if (filesize($fullPath) > 120 * 1024) {
            return self::BLANK_PNG_DATA_URI;
        }

        return $this->rawImageDataUri($fullPath);
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
