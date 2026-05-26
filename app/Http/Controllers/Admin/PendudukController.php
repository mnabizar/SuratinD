<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Models\Penduduk;
use App\Services\AuditLogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_kk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        $penduduk = $query->latest()->paginate(15);

        return view('admin.penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(StorePendudukRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        Penduduk::create($data);

        AuditLogService::log('Tambah Penduduk', "Menambahkan data penduduk: {$data['nama']} ({$data['nik']})");

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk.show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(UpdatePendudukRequest $request, Penduduk $penduduk)
    {
        $penduduk->update($request->validated());

        AuditLogService::log('Edit Penduduk', "Mengubah data penduduk: {$penduduk->nama} ({$penduduk->nik})");

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $nama = $penduduk->nama;
        $nik = $penduduk->nik;
        $penduduk->delete();

        AuditLogService::log('Hapus Penduduk', "Menghapus data penduduk: {$nama} ({$nik})");

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $penduduk = Penduduk::all();
        $pdf = Pdf::loadView('admin.penduduk.export-pdf', compact('penduduk'));

        return $pdf->download('data-penduduk-' . now()->format('Y-m-d') . '.pdf');
    }

    // API search for AJAX
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = Penduduk::where('nama', 'like', "%{$query}%")
            ->orWhere('nik', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'nik', 'nama', 'alamat']);

        return response()->json($results);
    }
}
