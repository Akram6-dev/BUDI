<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page { margin: 20px 20px 24px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111827; }
        .title { text-align: center; font-size: 18px; font-weight: 800; margin: 4px 0 2px; letter-spacing: 0.3px; }
        .meta { text-align: center; font-size: 10px; color: #6b7280; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 6px; vertical-align: top; }
        th { background: #f3f4f6; font-weight: 700; text-align: left; }
        .col-no { width: 36px; text-align: center; }
        .col-nama { width: 180px; }
        .col-kelas { width: 110px; }
        .col-status { width: 70px; text-transform: uppercase; }
        .col-img { width: 160px; }
        .img-box { width: 150px; height: 110px; border: 1px solid #e5e7eb; background: #ffffff; overflow: hidden; }
        .img-box img { width: 100%; height: 100%; object-fit: contain; }
        .ttd-box { width: 150px; height: 70px; border: 1px solid #e5e7eb; background: #ffffff; overflow: hidden; display: grid; place-items: center; padding: 4px; }
        .ttd-box img { max-width: 100%; max-height: 100%; object-fit: contain; display: block; }
        .section-label { text-align: center; font-size: 11px; font-weight: 700; color: #374151; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="title">{{ $title }}</div>
    <div class="section-label">
        {{ $section === 'student' ? 'SISWA' : 'GURU' }}
    </div>
    <div class="meta">
        Dicetak: {{ $generatedAt->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">ID</th>
                <th class="col-nama">Nama</th>
                @if($section === 'student')
                    <th class="col-kelas">Kelas</th>
                @endif
                <th class="col-status">Status</th>
                <th class="col-img">Foto</th>
                <th class="col-img">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
        @forelse($rows as $row)
            <tr>
                <td class="col-no">{{ $row['no'] }}</td>
                <td class="col-nama">{{ $row['nama'] }}</td>
                @if($section === 'student')
                    <td class="col-kelas">{{ $row['kelas'] }}</td>
                @endif
                <td class="col-status">{{ $row['status'] }}</td>
                <td class="col-img">
                    <div class="img-box">
                        <img src="{{ $row['foto_data_uri'] }}" alt="Foto">
                    </div>
                </td>
                <td class="col-img">
                    <div class="ttd-box">
                        <img src="{{ $row['ttd_data_uri'] }}" alt="Tanda Tangan">
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $section === 'student' ? 6 : 5 }}" style="text-align:center; color:#6b7280; padding: 18px;">
                    Tidak ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>

