<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\VerificationLog;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verification.index');
    }

    public function check(Request $request)
    {
        $surat = Surat::where('verification_code', $request->kode)->first();

        VerificationLog::create([
            'kode' => $request->kode,
            'status' => $surat ? 'VALID' : 'INVALID',
            'ip_address' => $request->ip()
        ]);

        return view('verification.result', compact('surat'));
    }
}