<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function form()
    {
        return view('tamu.guest-form');
    }

    public function storeForm(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'status'    => 'required|in:guru,siswa,murid',
            'class'     => 'nullable|string|max:50',
        ]);

        session([
            'tamu.nama'   => $request->full_name,
            'tamu.status' => $request->status === 'murid' ? 'siswa' : $request->status,
            'tamu.kelas'  => $request->status === 'murid' ? $request->class : null,
        ]);

        return redirect('/guest-photo');
    }

    public function photo()
    {
        return view('tamu.guest-photo');
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto')->store('foto', 'public');
        session(['tamu.foto' => $path]);

        return redirect('/guest-signature');
    }

    public function signature()
    {
        return view('tamu.guest-signature');
    }

    public function submit(Request $request)
    {
        // Tanda tangan opsional
        $ttdPath = null;
        if ($request->hasFile('tanda_tangan')) {
            $request->validate(['tanda_tangan' => 'image|max:2048']);
            $ttdPath = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
        } elseif ($request->filled('tanda_tangan_base64')) {
            // Simpan dari canvas base64
            $image = $request->tanda_tangan_base64;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = base64_decode($image);
            $filename = 'tanda_tangan/' . uniqid() . '.png';
            \Storage::disk('public')->put($filename, $image);
            $ttdPath = $filename;
        }

        Tamu::create([
            'nama'         => session('tamu.nama'),
            'status'       => session('tamu.status'),
            'kelas'        => session('tamu.kelas'),
            'foto'         => session('tamu.foto', ''),
            'tanda_tangan' => $ttdPath ?? '',
        ]);

        session()->forget(['tamu.nama', 'tamu.status', 'tamu.kelas', 'tamu.foto']);

        return redirect('/')->with('success', 'Data tamu berhasil disimpan!');
    }
}
