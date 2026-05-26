<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Penduduk</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 5px 8px; font-size: 8pt; }
        th { background: #4FC3F7; color: white; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { text-align: center; font-size: 9pt; color: #666; }
    </style>
</head>
<body>
    <h2>DATA PENDUDUK</h2>
    <p class="info">Diekspor: {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>JK</th>
                <th>TTL</th>
                <th>Alamat</th>
                <th>Pekerjaan</th>
                <th>Agama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penduduk as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir->format('d-m-Y') }}</td>
                <td>{{ $p->alamat }}</td>
                <td>{{ $p->pekerjaan ?? '-' }}</td>
                <td>{{ $p->agama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
