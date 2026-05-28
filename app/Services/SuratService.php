<?php

namespace App\Services;

use App\Models\Surat;
use App\Models\PengajuanSurat;
use App\Models\Setting;

class SuratService
{
    public static function generateNomorSurat(string $jenisSurat): string
    {
        $tahun = now()->year;
        $bulan = now()->format('m');

        $lastSurat = Surat::whereYear('created_at', $tahun)
            ->whereMonth('created_at', now()->month)
            ->count();

        $nomor = str_pad($lastSurat + 1, 3, '0', STR_PAD_LEFT);
        $kodeJenis = self::getKodeJenis($jenisSurat);

        return "SRT/{$kodeJenis}/{$nomor}/{$bulan}/{$tahun}";
    }

    private static function getKodeJenis(string $jenis): string
    {
        return match ($jenis) {
            'surat_domisili' => 'DOM',
            'surat_tidak_mampu' => 'STM',
            'surat_usaha' => 'SKU',
            'surat_belum_menikah' => 'SBM',
            'surat_sudah_menikah' => 'SSM',
            'surat_kelahiran' => 'SKL',
            'surat_kematian' => 'SKM',
            'pengajuan_ktp' => 'KTP',
            'pengajuan_kk' => 'PKK',
            default => 'UMM',
        };
    }

    public static function createFromPengajuan($pengajuan, $penduduk): Surat
    {
        $nomorSurat = self::generateNomorSurat($pengajuan->jenis_surat);
        $tanggalTerbit = now()->toDateString();

        $verificationCode = VerificationService::generateCode(
            $nomorSurat,
            $penduduk->nik,
            $tanggalTerbit
        );

        return Surat::create([
            'nomor_surat' => $nomorSurat,
            'penduduk_id' => $penduduk->id,
            'pengajuan_id' => $pengajuan->id,
            'jenis_surat' => $pengajuan->jenis_surat,
            'isi_surat' => self::generateIsiSurat($pengajuan, $penduduk),
            'verification_code' => $verificationCode,
            'tanggal_terbit' => $tanggalTerbit,
            'status' => 'diterbitkan',
            'created_by' => auth()->id(),
        ]);
    }

    private static function generateIsiSurat($pengajuan, $penduduk): string
    {
        $setting = Setting::getInstance();
        $jenisList = PengajuanSurat::jenisSuratList();
        $namaJenis = $jenisList[$pengajuan->jenis_surat] ?? $pengajuan->jenis_surat;

        return "Yang bertanda tangan di bawah ini, Kepala {$setting->nama_desa}, " .
            "Kecamatan {$setting->kecamatan}, Kabupaten {$setting->kabupaten}, " .
            "Provinsi {$setting->provinsi}, menerangkan bahwa:\n\n" .
            "Nama: {$penduduk->nama}\n" .
            "NIK: {$penduduk->nik}\n" .
            "Tempat/Tgl Lahir: {$penduduk->tempat_lahir}, {$penduduk->tanggal_lahir->format('d-m-Y')}\n" .
            "Jenis Kelamin: {$penduduk->jenis_kelamin}\n" .
            "Alamat: {$penduduk->alamat}\n" .
            "Pekerjaan: {$penduduk->pekerjaan}\n" .
            "Agama: {$penduduk->agama}\n\n" .
            "Adalah benar warga {$setting->nama_desa} yang memerlukan {$namaJenis}.\n" .
            "Keperluan: {$pengajuan->tujuan_surat}\n" .
            "Keterangan: {$pengajuan->keterangan}";
    }
}
