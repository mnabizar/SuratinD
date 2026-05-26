<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\Setting;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('penduduk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nomor_surat', 'like', "%{$search}%")
                ->orWhereHas('penduduk', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $surat = $query->latest()->paginate(15);
        return view('admin.surat.index', compact('surat'));
    }

    public function create()
    {
        $jenisSurat = PengajuanSurat::jenisSuratList();
        return view('admin.surat.create', compact('jenisSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'jenis_surat' => 'required|string',
            'isi_surat' => 'required|string',
        ]);

        $penduduk = Penduduk::findOrFail($request->penduduk_id);
        $nomorSurat = $this->generateNomorSurat($request->jenis_surat);
        $tanggalTerbit = now()->toDateString();
        $verificationCode = $this->generateVerificationCode($nomorSurat, $penduduk->nik, $tanggalTerbit);

        Surat::create([
            'nomor_surat' => $nomorSurat,
            'penduduk_id' => $penduduk->id,
            'jenis_surat' => $request->jenis_surat,
            'isi_surat' => $request->isi_surat,
            'verification_code' => $verificationCode,
            'tanggal_terbit' => $tanggalTerbit,
            'status' => 'diterbitkan',
            'created_by' => auth()->id(),
        ]);

        $this->logAudit('Buat Surat', "Membuat surat {$nomorSurat} untuk {$penduduk->nama}");

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function show(Surat $surat)
    {
        $surat->load('penduduk', 'pengajuan', 'creator');
        return view('admin.surat.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        $jenisSurat = PengajuanSurat::jenisSuratList();
        return view('admin.surat.edit', compact('surat', 'jenisSurat'));
    }

    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'isi_surat' => 'required|string',
            'status' => 'required|in:draft,diterbitkan,dibatalkan',
        ]);

        $surat->update($request->only('isi_surat', 'status'));

        $this->logAudit('Edit Surat', "Mengubah surat {$surat->nomor_surat}");

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        $nomor = $surat->nomor_surat;
        $surat->delete();

        $this->logAudit('Hapus Surat', "Menghapus surat {$nomor}");

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }

    public function cetak(Surat $surat)
    {
        $surat->load('penduduk');
        $setting = Setting::getInstance();

        $pdf = Pdf::loadView('admin.surat.cetak-pdf', compact('surat', 'setting'));
        $pdf->setPaper('A4', 'portrait');

        $this->logAudit('Cetak Surat', "Mencetak PDF surat {$surat->nomor_surat}");

        // Ganti "/" dengan "-" agar nama file valid
        $filename = 'surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

        return $pdf->download($filename);
    }

    // ========================================================
    // HELPER METHODS - WAJIB ADA DI BAWAH SINI
    // ========================================================

    private function generateNomorSurat(string $jenisSurat): string
    {
        $tahun = now()->year;
        $bulan = now()->format('m');

        $lastSurat = Surat::whereYear('created_at', $tahun)
            ->whereMonth('created_at', now()->month)
            ->count();

        $nomor = str_pad($lastSurat + 1, 3, '0', STR_PAD_LEFT);

        $kodeJenis = match ($jenisSurat) {
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

        return "SRT/{$kodeJenis}/{$nomor}/{$bulan}/{$tahun}";
    }

    private function generateVerificationCode(string $nomorSurat, string $nik, string $tanggalTerbit): string
    {
        $setting = Setting::getInstance();
        $data = $nomorSurat . $nik . $tanggalTerbit . $setting->secret_key;
        return hash('sha256', $data);
    }

    private function logAudit(string $aktivitas, ?string $deskripsi = null): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
