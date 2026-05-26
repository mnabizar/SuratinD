<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat', 'penduduk_id', 'pengajuan_id', 'jenis_surat',
        'isi_surat', 'verification_code', 'tanggal_terbit', 'status', 'created_by',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
