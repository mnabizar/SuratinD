<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Surat;
use App\Models\VerificationLog;

class VerificationService
{
    public static function generateCode(string $nomorSurat, string $nik, string $tanggalTerbit): string
    {
        $setting = Setting::getInstance();
        $data = $nomorSurat . $nik . $tanggalTerbit . $setting->secret_key;
        return hash('sha256', $data);
    }

    public static function verify(string $code): ?Surat
    {
        $surat = Surat::where('verification_code', $code)
            ->where('status', 'diterbitkan')
            ->first();

        VerificationLog::create([
            'kode' => $code,
            'status' => $surat ? 'valid' : 'tidak_valid',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);

        return $surat;
    }
}
