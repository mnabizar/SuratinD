<?php

namespace Database\Seeders;

use App\Models\PengajuanSurat;
use App\Models\Surat;
use App\Models\Penduduk;
use App\Models\AuditLog;
use App\Services\VerificationService;
use App\Services\SuratService;
use Illuminate\Database\Seeder;

class SamplePengajuanSeeder extends Seeder
{
    public function run(): void
    {
        // Sample pengajuan
        $pengajuan1 = PengajuanSurat::create([
            'user_id' => 3,
            'jenis_surat' => 'surat_domisili',
            'tujuan_surat' => 'Untuk keperluan melamar kerja',
            'keterangan' => 'Butuh segera',
            'status' => 'selesai',
            'catatan_admin' => 'Disetujui',
            'created_at' => now()->subDays(5),
        ]);

        // Create surat for approved pengajuan
        $penduduk = Penduduk::where('nik', '1234567890123458')->first();
        if ($penduduk) {
            $nomorSurat = 'SRT/DOM/001/01/2024';
            $tanggalTerbit = now()->subDays(4)->toDateString();
            $verificationCode = VerificationService::generateCode($nomorSurat, $penduduk->nik, $tanggalTerbit);

            Surat::create([
                'nomor_surat' => $nomorSurat,
                'penduduk_id' => $penduduk->id,
                'pengajuan_id' => $pengajuan1->id,
                'jenis_surat' => 'surat_domisili',
                'isi_surat' => "Yang bertanda tangan di bawah ini menerangkan bahwa:\n\nNama: {$penduduk->nama}\nNIK: {$penduduk->nik}\nAlamat: {$penduduk->alamat}\n\nAdalah benar warga Desa Sukamaju.",
                'verification_code' => $verificationCode,
                'tanggal_terbit' => $tanggalTerbit,
                'status' => 'diterbitkan',
                'created_by' => 1,
            ]);
        }

        // Pending pengajuan
        PengajuanSurat::create([
            'user_id' => 3,
            'jenis_surat' => 'surat_tidak_mampu',
            'tujuan_surat' => 'Untuk keringanan biaya sekolah anak',
            'keterangan' => 'Anak bersekolah di SMA Negeri 1',
            'status' => 'pending',
            'created_at' => now()->subDays(1),
        ]);

        PengajuanSurat::create([
            'user_id' => 3,
            'jenis_surat' => 'surat_usaha',
            'tujuan_surat' => 'Untuk pengajuan kredit usaha',
            'keterangan' => 'Usaha warung makan',
            'status' => 'diproses',
            'created_at' => now()->subDays(2),
        ]);

        // Sample audit logs
        $activities = [
            ['Login', 'User login berhasil'],
            ['Tambah Penduduk', 'Menambahkan data penduduk: Ahmad Fauzi'],
            ['Persetujuan Surat', 'Menyetujui pengajuan surat domisili'],
            ['Cetak Surat', 'Mencetak PDF surat SRT/DOM/001/01/2024'],
            ['Edit Penduduk', 'Mengubah data penduduk: Siti Aminah'],
        ];

        foreach ($activities as $i => $activity) {
            AuditLog::create([
                'user_id' => 1,
                'aktivitas' => $activity[0],
                'deskripsi' => $activity[1],
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours($i + 1),
            ]);
        }
    }
}
