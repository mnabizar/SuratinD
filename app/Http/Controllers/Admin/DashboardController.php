<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\Surat;
use App\Models\VerificationLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();
        $totalSurat = Surat::count();
        $suratBulanIni = Surat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalVerifikasi = VerificationLog::where('status', 'valid')->count();
        $pengajuanMenunggu = PengajuanSurat::where('status', 'pending')->count();

        // Chart data - surat per bulan (12 bulan terakhir)
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Surat::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $chartData[] = [
                'bulan' => $date->format('M'),
                'jumlah' => $count,
            ];
        }

        // Aktivitas terbaru
        $aktivitasTerbaru = AuditLog::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        // Log verifikasi terbaru
        $verifikasiTerbaru = VerificationLog::latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPenduduk',
            'totalSurat',
            'suratBulanIni',
            'totalVerifikasi',
            'pengajuanMenunggu',
            'chartData',
            'aktivitasTerbaru',
            'verifikasiTerbaru'
        ));
    }
}
