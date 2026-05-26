<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanRequest;
use App\Models\PengajuanSurat;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanSurat::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $jenisSurat = PengajuanSurat::jenisSuratList();
        return view('user.pengajuan.create', compact('jenisSurat'));
    }

    public function store(StorePengajuanRequest $request)
    {
        $filePendukung = [];

        if ($request->hasFile('file_ktp')) {
            $filePendukung['ktp'] = $request->file('file_ktp')
                ->store('pengajuan/' . auth()->id(), 'public');
        }

        if ($request->hasFile('file_kk')) {
            $filePendukung['kk'] = $request->file('file_kk')
                ->store('pengajuan/' . auth()->id(), 'public');
        }

        if ($request->hasFile('file_tambahan')) {
            $filePendukung['tambahan'] = $request->file('file_tambahan')
                ->store('pengajuan/' . auth()->id(), 'public');
        }

        PengajuanSurat::create([
            'user_id' => auth()->id(),
            'jenis_surat' => $request->jenis_surat,
            'tujuan_surat' => $request->tujuan_surat,
            'keterangan' => $request->keterangan,
            'file_pendukung' => $filePendukung,
            'status' => 'pending',
        ]);

        return redirect()->route('user.pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dikirim. Silakan tunggu verifikasi dari admin.');
    }

    public function show(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403);
        }

        $pengajuan->load('surat');
        return view('user.pengajuan.show', compact('pengajuan'));
    }

    public function downloadSurat(PengajuanSurat $pengajuan)
    {
    if ($pengajuan->user_id !== auth()->id()) {
        abort(403);
    }

    $surat = $pengajuan->surat;

    if (!$surat || $surat->status !== 'diterbitkan') {
        return back()->with('error', 'Surat belum tersedia untuk diunduh.');
    }

    $surat->load('penduduk');
    $setting = \App\Models\Setting::getInstance();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.surat.cetak-pdf', compact('surat', 'setting'));
    $pdf->setPaper('A4', 'portrait');

    // PERBAIKAN: Ganti "/" dengan "-" pada nama file
    $filename = 'surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

    return $pdf->download($filename);
    }

}
