<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $fotoPath = $this->storeBase64Image($request->input('foto_base64'), 'foto');
        $ttdPath = $this->storeBase64Image($request->input('tanda_tangan_base64'), 'tanda_tangan');

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

    private function storeBase64Image(?string $dataUri, string $directory): ?string
    {
        if (!$dataUri || !preg_match('/^data:image\/(png|jpe?g|webp);base64,(.+)$/i', $dataUri, $matches)) {
            return null;
        }

        $extension = strtolower($matches[1]) === 'jpeg' ? 'jpg' : strtolower($matches[1]);
        $image = base64_decode($matches[2], true);
        if ($image === false) {
            return null;
        }

        $filename = $directory . '/' . uniqid('', true) . '.' . $extension;
        Storage::disk('public')->put($filename, $image);

        return $filename;
    }
}
