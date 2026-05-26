<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Services\VerificationService;
use Illuminate\Http\Request;

class VerifikasiPublikController extends Controller
{
    public function index()
    {
        return view('public.verifikasi');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
        ]);

        $surat = VerificationService::verify($request->kode);

        if ($surat) {
            $surat->load('penduduk');
            return view('public.verifikasi', [
                'result' => 'valid',
                'surat' => $surat,
            ]);
        }

        return view('public.verifikasi', [
            'result' => 'tidak_valid',
        ]);
    }
}
