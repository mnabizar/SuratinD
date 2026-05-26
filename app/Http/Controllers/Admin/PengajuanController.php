<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Services\AuditLogService;
use App\Services\SuratService;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanSurat::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $pengajuan = $query->latest()->paginate(15);

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load('user', 'surat');
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        // Cari data penduduk berdasarkan NIK user
        $penduduk = Penduduk::where('nik', $pengajuan->user->nik)->first();

        if (!$penduduk) {
            return back()->with('error', 'Data penduduk tidak ditemukan. Pastikan NIK pemohon terdaftar di data penduduk.');
        }

        // Update status pengajuan
        $pengajuan->update([
            'status' => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Generate surat
        $surat = SuratService::createFromPengajuan($pengajuan, $penduduk);

        // Update status menjadi selesai
        $pengajuan->update(['status' => 'selesai']);

        AuditLogService::log('Persetujuan Surat', "Menyetujui pengajuan #{$pengajuan->id} - {$pengajuan->jenis_surat}");

        return redirect()->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan berhasil disetujui dan surat telah diterbitkan.');
    }

    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        AuditLogService::log('Tolak Pengajuan', "Menolak pengajuan #{$pengajuan->id} - {$pengajuan->jenis_surat}");

        return redirect()->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function process(PengajuanSurat $pengajuan)
    {
        $pengajuan->update(['status' => 'diproses']);

        AuditLogService::log('Proses Pengajuan', "Memproses pengajuan #{$pengajuan->id}");

        return back()->with('success', 'Status pengajuan diubah menjadi diproses.');
    }
}
