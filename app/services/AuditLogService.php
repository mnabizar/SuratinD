<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function log(string $aktivitas, ?string $deskripsi = null): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
