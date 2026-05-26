<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['kode', 'status', 'ip_address', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
