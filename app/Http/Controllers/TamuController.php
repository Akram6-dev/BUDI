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

    public function signature()
    {
        return view('tamu.guest-signature');
    }

    public function submit(Request $request)
    {
        // Proses foto dari base64
        $fotoPath = null;
        if ($request->filled('foto_base64')) {
            $image = $request->foto_base64;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = base64_decode($image);
            $filename = 'foto/' . uniqid() . '.png';
            \Storage::disk('public')->put($filename, $image);
            $fotoPath = $filename;
        }

        // Proses tanda tangan dari base64 (opsional)
        $ttdPath = null;
        if ($request->filled('tanda_tangan_base64')) {
            $image = $request->tanda_tangan_base64;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = base64_decode($image);
            $filename = 'tanda_tangan/' . uniqid() . '.png';
            \Storage::disk('public')->put($filename, $image);
            $ttdPath = $filename;
        }

        // Buat record di database
        Tamu::create([
            'nama'         => session('tamu.nama'),
            'status'       => session('tamu.status'),
            'kelas'        => session('tamu.kelas'),
            'foto'         => $fotoPath ?? '',
            'tanda_tangan' => $ttdPath ?? '',
        ]);

        session()->forget(['tamu.nama', 'tamu.status', 'tamu.kelas']);

        return redirect('/')->with('success', 'Data tamu berhasil disimpan!');
    }
}
