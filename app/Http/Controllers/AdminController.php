<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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

        $query = $this->buildExportQuery($request, $isSchool);

        $items = $query->get(['id', 'nama', 'instansi', 'asal_sekolah', 'status', 'ulasan', 'foto', 'tanda_tangan']);

        $rows = $items->values()->map(function ($item, $index) {
            $signaturePath = ($item->tanda_tangan ?? '') !== '' ? $item->tanda_tangan : null;
            $fotoPath = $this->resolveStoredImagePath(($item->foto ?? '') !== '' ? $item->foto : null);
            $ttdPath = $this->resolveStoredImagePath($signaturePath);

            if (($item->foto ?? '') !== '' && !$fotoPath) {
                Log::warning('Foto export PDF tidak ditemukan.', ['id' => $item->id, 'foto' => $item->foto]);
            }

            if ($signaturePath && !$ttdPath) {
                Log::warning('Tanda tangan export PDF tidak ditemukan.', ['id' => $item->id, 'tanda_tangan' => $signaturePath]);
            }

            return [
                'no' => $index + 1,
                'nama' => $item->nama,
                'instansi' => $item->instansi ?? '-',
                'asal_sekolah' => $item->asal_sekolah ?? '-',
                'ulasan' => $item->ulasan ?? 'senang',
                'status' => $item->status,
                'foto_src' => $fotoPath ? $this->imageToPdfSource($fotoPath, 220, 165, 68, 'foto') : null,
                'ttd_src' => $ttdPath ? $this->imageToPdfSource($ttdPath, 220, 100, 78, 'ttd') : null,
            ];
        });

        $schoolFilter = $isSchool ? trim((string) ($request->get('search_sekolah', $request->get('search_kelas', '')))) : '';
        $sectionLabel = $isSchool
            ? 'SEKOLAH' . ($schoolFilter !== '' ? ' ' . strtoupper($schoolFilter) : '')
            : 'INSTANSI';
        $pdfChroot = array_filter(array_unique([
            base_path(),
            storage_path(),
            public_path(),
            dirname(base_path()),
            !empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : null,
            !empty($_SERVER['DOCUMENT_ROOT']) ? dirname($_SERVER['DOCUMENT_ROOT']) : null,
        ]));

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
        ->setOption('isRemoteEnabled', true)
        ->setOption('chroot', $pdfChroot);

        $filename = $isSchool ? 'daftar-kehadiran-sekolah.pdf' : 'daftar-kehadiran-instansi.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect('/login');
        }

        $section = $request->get('section', 'instansi');
        $isSchool = in_array($section, ['sekolah', 'student', 'school']);
        $items = $this->buildExportQuery($request, $isSchool)
            ->get(['id', 'nama', 'instansi', 'asal_sekolah', 'status', 'ulasan', 'foto', 'tanda_tangan', 'created_at']);

        $schoolFilter = $isSchool ? trim((string) ($request->get('search_sekolah', $request->get('search_kelas', '')))) : '';
        $sectionLabel = $isSchool
            ? 'SEKOLAH' . ($schoolFilter !== '' ? ' ' . strtoupper($schoolFilter) : '')
            : 'INSTANSI';

        $filename = $isSchool ? 'daftar-kehadiran-sekolah.xlsx' : 'daftar-kehadiran-instansi.xlsx';
        $exportDir = storage_path('app/exports');
        if (!is_dir($exportDir)) {
            @mkdir($exportDir, 0755, true);
        }

        $filePath = $exportDir . DIRECTORY_SEPARATOR . uniqid('export-', true) . '.xlsx';
        $this->writeExcelFile($filePath, 'DAFTAR KEHADIRAN PENGUNJUNG', $sectionLabel, $items, $isSchool);

        return response()
            ->download($filePath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            ])
            ->deleteFileAfterSend(true);
    }

    private function writeExcelFile(string $filePath, string $title, string $sectionLabel, $items, bool $isSchool): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($isSchool ? 'Tamu Sekolah' : 'Tamu Instansi');

        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A1', $title);
        $sheet->setCellValue('A2', $sectionLabel);
        $sheet->setCellValue('A3', 'Dicetak: ' . now()->format('d/m/Y H:i'));

        $headers = ['No', 'Foto', 'Tanda Tangan', 'Nama Tamu', $isSchool ? 'Asal Sekolah' : 'Instansi', 'Ulasan', 'Status', 'Waktu Input', 'ID'];
        $sheet->fromArray($headers, null, 'A5');

        $rowNumber = 6;
        foreach ($items as $index => $item) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValue('D' . $rowNumber, $item->nama);
            $sheet->setCellValue('E' . $rowNumber, $isSchool ? ($item->asal_sekolah ?? '-') : ($item->instansi ?? '-'));
            $sheet->setCellValue('F' . $rowNumber, strtoupper($item->ulasan ?? '-'));
            $sheet->setCellValue('G' . $rowNumber, strtoupper($item->status ?? '-'));
            $sheet->setCellValue('H' . $rowNumber, optional($item->created_at)->format('d/m/Y H:i'));
            $sheet->setCellValue('I' . $rowNumber, $item->id);

            // Set tinggi baris agar foto & tanda tangan muat dengan proporsional
            $sheet->getRowDimension($rowNumber)->setRowHeight(55);

            // Sematkan Foto Tamu jika ada
            $fotoPath = $this->resolveStoredImagePath(($item->foto ?? '') !== '' ? $item->foto : null);
            if ($fotoPath && @is_file($fotoPath)) {
                try {
                    $drawingFoto = new Drawing();
                    $drawingFoto->setName('Foto');
                    $drawingFoto->setDescription('Foto ' . $item->nama);
                    $drawingFoto->setPath($fotoPath);
                    $drawingFoto->setCoordinates('B' . $rowNumber);
                    $drawingFoto->setHeight(50);
                    $drawingFoto->setOffsetX(12);
                    $drawingFoto->setOffsetY(4);
                    $drawingFoto->setWorksheet($sheet);
                } catch (\Throwable $e) {
                    $sheet->setCellValue('B' . $rowNumber, '-');
                }
            } else {
                $sheet->setCellValue('B' . $rowNumber, '-');
            }

            // Sematkan Tanda Tangan Tamu jika ada
            $ttdPath = $this->resolveStoredImagePath(($item->tanda_tangan ?? '') !== '' ? $item->tanda_tangan : null);
            if ($ttdPath && @is_file($ttdPath)) {
                try {
                    $drawingTtd = new Drawing();
                    $drawingTtd->setName('Tanda Tangan');
                    $drawingTtd->setDescription('TTD ' . $item->nama);
                    $drawingTtd->setPath($ttdPath);
                    $drawingTtd->setCoordinates('C' . $rowNumber);
                    $drawingTtd->setHeight(40);
                    $drawingTtd->setOffsetX(15);
                    $drawingTtd->setOffsetY(8);
                    $drawingTtd->setWorksheet($sheet);
                } catch (\Throwable $e) {
                    $sheet->setCellValue('C' . $rowNumber, '-');
                }
            } else {
                $sheet->setCellValue('C' . $rowNumber, '-');
            }

            $rowNumber++;
        }

        if ($rowNumber === 6) {
            $sheet->mergeCells('A6:I6');
            $sheet->setCellValue('A6', 'Tidak ada data.');
            $rowNumber = 7;
        }

        $lastDataRow = $rowNumber - 1;

        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A3')->getFont()->setSize(10)->getColor()->setRGB('4B5563');

        $sheet->getStyle('A5:I5')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '111827']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A5:I' . $lastDataRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '9CA3AF'],
                ],
            ],
        ]);

        $sheet->getStyle('A6:C' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F6:I' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I' . $lastDataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        foreach (['A' => 8, 'B' => 16, 'C' => 20, 'D' => 26, 'E' => 28, 'F' => 14, 'G' => 14, 'H' => 18, 'I' => 8] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter('A5:I' . $lastDataRow);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        $spreadsheet->disconnectWorksheets();
    }

    private function buildExportQuery(Request $request, bool $isSchool)
    {
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

        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'], true)) {
            return $query->orderBy('nama', $request->sort);
        }

        return $query->orderBy('created_at', 'desc');
    }

    private function imageToPdfSource(string $fullPath, int $maxWidth, int $maxHeight, int $quality, string $prefix): ?string
    {
        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            $optimized = $this->optimizedImageForPdf($fullPath, $maxWidth, $maxHeight, $quality, $prefix);
            if ($optimized !== null) {
                return $optimized;
            }
        }

        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'], true)) {
            return str_replace('\\', '/', $fullPath);
        }

        if (@filesize($fullPath) <= 4 * 1024 * 1024) {
            return $this->rawImageDataUri($fullPath);
        }

        return null;
    }

    private function resolveStoredImagePath(?string $storedPath): ?string
    {
        if (!$storedPath) {
            return null;
        }

        $cleanPath = trim(str_replace('\\', '/', $storedPath));

        if (preg_match('#^https?://#i', $cleanPath)) {
            $urlPath = parse_url($cleanPath, PHP_URL_PATH);
            $cleanPath = is_string($urlPath) ? $urlPath : '';
        }

        $cleanPath = rawurldecode($cleanPath);
        $cleanPath = ltrim($cleanPath, '/');
        $cleanPath = preg_replace('#^(public/|storage/|app/public/)+#i', '', $cleanPath);

        if ($cleanPath === '' || str_contains($cleanPath, '..')) {
            return null;
        }

        $candidates = [
            storage_path('app/public/' . $cleanPath),
            public_path('storage/' . $cleanPath),
            public_path($cleanPath),
            base_path('storage/app/public/' . $cleanPath),
            base_path('public/storage/' . $cleanPath),
            base_path('public_html/storage/' . $cleanPath),
            base_path('public_html/' . $cleanPath),
            dirname(base_path()) . '/storage/app/public/' . $cleanPath,
            dirname(base_path()) . '/public_html/storage/' . $cleanPath,
        ];

        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $documentRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
            $candidates[] = $documentRoot . '/storage/' . $cleanPath;
            $candidates[] = $documentRoot . '/' . $cleanPath;
            $candidates[] = dirname($documentRoot) . '/storage/app/public/' . $cleanPath;
        }

        foreach (array_unique($candidates) as $candidate) {
            if ($candidate && @is_file($candidate) && @is_readable($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function optimizedImageForPdf(string $fullPath, int $maxWidth, int $maxHeight, int $quality, string $prefix): ?string
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

        $pdfImageDir = storage_path('app/pdf-images');
        if (!is_dir($pdfImageDir) && !@mkdir($pdfImageDir, 0755, true)) {
            return 'data:image/jpeg;base64,' . base64_encode($jpeg);
        }

        $cacheName = $prefix . '-' . md5($fullPath . '|' . @filemtime($fullPath) . '|' . $maxWidth . 'x' . $maxHeight . '|' . $quality) . '.jpg';
        $cachePath = $pdfImageDir . DIRECTORY_SEPARATOR . $cacheName;

        if (!@is_file($cachePath) && @file_put_contents($cachePath, $jpeg) === false) {
            return 'data:image/jpeg;base64,' . base64_encode($jpeg);
        }

        return str_replace('\\', '/', $cachePath);
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
