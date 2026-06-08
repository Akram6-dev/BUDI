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

        $items = $query->orderBy('created_at', 'desc')->get();

        $whitePngDataUri = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO9WlWcAAAAASUVORK5CYII=';
        $toDataUri = function (?string $relativePath) use ($whitePngDataUri): string {
            if (!$relativePath) {
                return $whitePngDataUri;
            }

            $relativePath = ltrim($relativePath, '/');
            $fullPath = storage_path('app/public/' . $relativePath);
            if (!is_file($fullPath)) {
                return $whitePngDataUri;
            }

            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $mime = match ($ext) {
                'jpg', 'jpeg' => 'image/jpeg',
                'webp' => 'image/webp',
                'gif' => 'image/gif',
                default => 'image/png',
            };

            $data = base64_encode((string) file_get_contents($fullPath));
            return "data:$mime;base64,$data";
        };

        $rows = $items->values()->map(function ($item, $index) use ($toDataUri, $whitePngDataUri) {
            $signaturePath = ($item->tanda_tangan ?? '') !== '' ? $item->tanda_tangan : null;

            return [
                'no' => $index + 1,
                'nama' => $item->nama,
                'kelas' => $item->kelas,
                'status' => $item->status,
                'foto_data_uri' => $toDataUri(($item->foto ?? '') !== '' ? $item->foto : null),
                'ttd_data_uri' => $signaturePath ? $toDataUri($signaturePath) : $whitePngDataUri,
            ];
        });

        $pdf = Pdf::loadView('admin.export-pdf', [
            'title' => 'DAFTAR KEHADIRAN',
            'section' => $section,
            'rows' => $rows,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        $filename = $section === 'student'
            ? 'daftar-kehadiran-siswa.pdf'
            : 'daftar-kehadiran-guru.pdf';

        return $pdf->download($filename);
    }
}
