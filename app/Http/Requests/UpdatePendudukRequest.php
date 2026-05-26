<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendudukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $pendudukId = $this->route('penduduk')->id;

        return [
            'nik' => "required|string|size:16|unique:penduduk,nik,{$pendudukId}",
            'no_kk' => 'required|string|size:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'pekerjaan' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'golongan_darah' => 'nullable|string|in:A,B,AB,O,-',
        ];
    }
}
