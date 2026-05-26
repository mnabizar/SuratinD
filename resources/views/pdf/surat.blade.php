<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>

    <center>
        <h2>PEMERINTAH DESA</h2>
        <h3>SURAT KETERANGAN</h3>
    </center>

    <hr>

    <p>Nomor Surat : {{ $surat->nomor_surat }}</p>

    <p>
        Surat ini menerangkan bahwa:
    </p>

    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $surat->penduduk->nama }}</td>
        </tr>

        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->penduduk->nik }}</td>
        </tr>
    </table>

    <br>

    <p>
        {{ $surat->isi_surat }}
    </p>

    <br><br>

    <p>Kode Verifikasi:</p>

    <small>{{ $surat->verification_code }}</small>

</body>
</html>