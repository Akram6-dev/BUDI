<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
}
