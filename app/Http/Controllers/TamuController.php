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

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'status' => 'required|in:instansi,sekolah',
            'instansi' => 'required_if:status,instansi|nullable|string|max:150',
            'asal_sekolah' => 'required_if:status,sekolah|nullable|string|max:150',
            'ulasan' => 'required|in:senang,biasa,sedih',
            'foto_base64' => 'required|string',
            'tanda_tangan_base64' => 'nullable|string',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'status.required' => 'Silakan pilih status (Instansi atau Sekolah).',
            'instansi.required_if' => 'Nama instansi wajib diisi jika memilih status Instansi.',
            'asal_sekolah.required_if' => 'Asal sekolah wajib diisi jika memilih status Sekolah.',
            'ulasan.required' => 'Silakan berikan penilaian ulasan Anda.',
            'foto_base64.required' => 'Foto pengunjung wajib diambil.',
        ]);

        $fotoPath = $this->storeBase64Image($request->input('foto_base64'), 'foto');
        if (!$fotoPath) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal memproses foto pengunjung. Silakan ambil ulang.'], 422);
            }
            return back()->withInput()->with('error', 'Gagal memproses foto pengunjung. Silakan ambil ulang.');
        }

        $ttdPath = $this->storeBase64Image($request->input('tanda_tangan_base64'), 'tanda_tangan');

        $tamu = Tamu::create([
            'nama' => $validated['nama'],
            'status' => $validated['status'],
            'instansi' => $validated['status'] === 'instansi' ? $validated['instansi'] : null,
            'asal_sekolah' => $validated['status'] === 'sekolah' ? $validated['asal_sekolah'] : null,
            'ulasan' => $validated['ulasan'],
            'foto' => $fotoPath,
            'tanda_tangan' => $ttdPath ?? '',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih telah berkunjung! Kehadiran Anda telah tercatat dengan baik.',
                'redirect' => '/'
            ]);
        }

        return redirect('/')->with('success', 'Terima kasih telah berkunjung! Kehadiran Anda telah tercatat dengan baik.');
    }

    public function photo()
    {
        return redirect('/guest-form');
    }

    public function signature()
    {
        return redirect('/guest-form');
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
