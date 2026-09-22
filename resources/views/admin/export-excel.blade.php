{!! "\xEF\xBB\xBF" !!}<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #9ca3af;
            padding: 8px;
            vertical-align: middle;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        th {
            background: #e5e7eb;
            font-weight: bold;
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
        }

        .meta {
            color: #4b5563;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="7" class="title">{{ $title }}</td>
        </tr>
        <tr>
            <td colspan="7" class="subtitle">{{ $sectionLabel }}</td>
        </tr>
        <tr>
            <td colspan="7" class="meta">Dicetak: {{ $generatedAt->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th>Nama Tamu</th>
            <th>{{ $isSchool ? 'Asal Sekolah' : 'Instansi' }}</th>
            <th>Ulasan</th>
            <th>Status</th>
            <th>Waktu Input</th>
            <th>ID</th>
        </tr>

        @forelse($items as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $isSchool ? ($item->asal_sekolah ?? '-') : ($item->instansi ?? '-') }}</td>
                <td style="text-align: center;">{{ strtoupper($item->ulasan ?? '-') }}</td>
                <td style="text-align: center;">{{ strtoupper($item->status ?? '-') }}</td>
                <td style="text-align: center;">{{ optional($item->created_at)->format('d/m/Y H:i') }}</td>
                <td style="text-align: center;">{{ $item->id }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
