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
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #d1d5db; padding: 6px 6px; vertical-align: middle; }
        th { background: #f3f4f6; font-weight: 700; text-align: left; }
        .col-no { width: 36px; text-align: center; }
        .col-nama { width: 180px; text-align: center; }
        .col-kelas { width: 105px; text-align: center; }
        .col-status { width: 70px; text-align: center; text-transform: uppercase; }
        .col-img { width: 145px; text-align: center; vertical-align: middle; }
        .img-cell, .ttd-cell { text-align: center; vertical-align: middle; }
        .img-box,
        .ttd-box {
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            overflow: hidden;
            text-align: center;
        }
        .img-box { width: 120px; height: 90px; padding: 3px; }
        .ttd-box { width: 120px; height: 54px; padding: 3px; }
        .img-box img,
        .ttd-box img {
            margin: 0 auto;
            vertical-align: middle;
        }
        .img-box img { max-width: 120px; max-height: 90px; }
        .ttd-box img { max-width: 120px; max-height: 54px; }
        .section-label { text-align: center; font-size: 11px; font-weight: 700; color: #374151; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="title">{{ $title }}</div>
    <div class="section-label">
        {{ $sectionLabel ?? ($isSchool ? 'SEKOLAH' : 'INSTANSI') }}
    </div>
    <div class="meta">
        Dicetak: {{ $generatedAt->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Nama Tamu</th>
                @if($isSchool ?? ($section === 'sekolah'))
                    <th class="col-kelas">Asal Sekolah</th>
                @else
                    <th class="col-kelas">Instansi</th>
                @endif
                <th class="col-status">Ulasan</th>
                <th class="col-status">Status</th>
                <th class="col-img">Foto</th>
                <th class="col-img">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
        @forelse($rows as $row)
            <tr>
                <td class="col-no">{{ $row['no'] }}</td>
                <td class="col-nama" style="text-align: left; padding-left: 8px;">{{ $row['nama'] }}</td>
                @if($isSchool ?? ($section === 'sekolah'))
                    <td class="col-kelas">{{ $row['asal_sekolah'] ?? '-' }}</td>
                @else
                    <td class="col-kelas">{{ $row['instansi'] ?? '-' }}</td>
                @endif
                <td class="col-status">
                    @if(($row['ulasan'] ?? '') === 'senang')
                        SENANG
                    @elseif(($row['ulasan'] ?? '') === 'menarik' || ($row['ulasan'] ?? '') === 'biasa')
                        MENARIK
                    @elseif(($row['ulasan'] ?? '') === 'unik' || ($row['ulasan'] ?? '') === 'sedih')
                        UNIK
                    @else
                        -
                    @endif
                </td>
                <td class="col-status">{{ strtoupper($row['status']) }}</td>
                <td class="col-img img-cell">
                    @if(!empty($row['foto_src']))
                        <div class="img-box">
                            <img src="{{ $row['foto_src'] }}" alt="Foto">
                        </div>
                    @else
                        <span style="color: #9ca3af; font-size: 9px; font-style: italic;">Tidak ada foto</span>
                    @endif
                </td>
                <td class="col-img ttd-cell">
                    @if(!empty($row['ttd_src']))
                        <div class="ttd-box">
                            <img src="{{ $row['ttd_src'] }}" alt="Tanda Tangan">
                        </div>
                    @else
                        <span style="color: #9ca3af; font-size: 9px;">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#6b7280; padding: 18px;">
                    Tidak ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>
