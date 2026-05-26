<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalPengajuan = PengajuanSurat::where('user_id', $user->id)->count();
        $diproses = PengajuanSurat::where('user_id', $user->id)->where('status', 'diproses')->count();
        $disetujui = PengajuanSurat::where('user_id', $user->id)->whereIn('status', ['disetujui', 'selesai'])->count();
        $ditolak = PengajuanSurat::where('user_id', $user->id)->where('status', 'ditolak')->count();

        $pengajuanTerbaru = PengajuanSurat::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPengajuan', 'diproses', 'disetujui', 'ditolak', 'pengajuanTerbaru'
        ));
    }
}
