<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->nomor_surat }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 0;
            padding: 30px 50px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .kop-surat h3 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 10pt;
        }
        .logo {
            width: 70px;
            height: 70px;
            position: absolute;
            left: 50px;
            top: 30px;
        }
        .nomor-surat {
            text-align: center;
            margin: 20px 0;
        }
        .nomor-surat h4 {
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .isi-surat {
            text-align: justify;
            margin: 20px 0;
            white-space: pre-wrap;
        }
        .tanda-tangan {
            margin-top: 40px;
            text-align: right;
            padding-right: 60px;
        }
        .tanda-tangan .nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .footer-verifikasi {
            margin-top: 50px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 8pt;
            color: #666;
            text-align: center;
        }
        .verification-box {
            margin-top: 15px;
            padding: 8px;
            border: 1px dashed #999;
            text-align: center;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    @if($setting->logo)
    <img src="{{ public_path('storage/' . $setting->logo) }}" class="logo" alt="Logo">
    @endif

    <div class="kop-surat">
        <h2>PEMERINTAH {{ strtoupper($setting->kabupaten) }}</h2>
        <h2>KECAMATAN {{ strtoupper($setting->kecamatan) }}</h2>
        <h3>KANTOR KEPALA {{ strtoupper($setting->nama_desa) }}</h3>
        <p>{{ $setting->alamat_desa ?? 'Alamat Desa' }}</p>
    </div>

    <!-- Nomor Surat -->
    <div class="nomor-surat">
        @php
            $jenisList = \App\Models\PengajuanSurat::jenisSuratList();
            $namaJenis = $jenisList[$surat->jenis_surat] ?? 'Surat Keterangan';
        @endphp
        <h4>{{ strtoupper($namaJenis) }}</h4>
        <p>Nomor: {{ $surat->nomor_surat }}</p>
    </div>

    <!-- Isi Surat -->
    <div class="isi-surat">
        {!! nl2br(e($surat->isi_surat)) !!}
    </div>

    <p style="margin-top:20px;">Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan">
        <p>{{ $setting->nama_desa }}, {{ $surat->tanggal_terbit->translatedFormat('d F Y') }}</p>
        <p>Kepala {{ $setting->nama_desa }}</p>
        <p class="nama">________________________</p>
    </div>

    <!-- Footer Verifikasi -->
    <div class="footer-verifikasi">
        <div class="verification-box">
            <strong>KODE VERIFIKASI DIGITAL</strong><br>
            {{ $surat->verification_code }}<br><br>
            <small>Verifikasi keaslian surat di: {{ config('app.url') }}/verifikasi</small>
        </div>
        <p style="margin-top:8px;">Dokumen ini diterbitkan secara digital oleh Sistem Pelayanan Surat Desa (SuratinD)</p>
    </div>
</body>
</html>
