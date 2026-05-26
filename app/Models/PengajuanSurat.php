<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id', 'jenis_surat', 'tujuan_surat', 'keterangan',
        'file_pendukung', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'file_pendukung' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function surat()
    {
        return $this->hasOne(Surat::class, 'pengajuan_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'diproses' => '<span class="badge bg-info">Diproses</span>',
            'disetujui' => '<span class="badge bg-success">Disetujui</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
            'selesai' => '<span class="badge bg-primary">Selesai</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public static function jenisSuratList(): array
    {
        return [
            'surat_domisili' => 'Surat Keterangan Domisili',
            'surat_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_usaha' => 'Surat Keterangan Usaha',
            'surat_belum_menikah' => 'Surat Keterangan Belum Menikah',
            'surat_sudah_menikah' => 'Surat Keterangan Sudah Menikah',
            'surat_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_kematian' => 'Surat Keterangan Kematian',
            'pengajuan_ktp' => 'Pengajuan KTP',
            'pengajuan_kk' => 'Pengajuan KK',
        ];
    }
}
