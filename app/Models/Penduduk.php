<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik', 'no_kk', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'pekerjaan', 'pendidikan',
        'agama', 'status_perkawinan', 'golongan_darah', 'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
