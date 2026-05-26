<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_desa', 'kecamatan', 'kabupaten', 'provinsi',
        'logo', 'secret_key', 'alamat_desa', 'kode_pos', 'telepon', 'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public static function getInstance(): self
    {
        return self::first() ?? self::create([
            'nama_desa' => 'Desa Contoh',
            'kecamatan' => 'Kecamatan Contoh',
            'kabupaten' => 'Kabupaten Contoh',
            'provinsi' => 'Provinsi Contoh',
            'secret_key' => 'suratind-secret-' . now()->year,
        ]);
    }
}
