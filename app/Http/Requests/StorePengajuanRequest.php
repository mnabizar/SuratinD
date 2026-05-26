<?php

namespace App\Http\Requests;

use App\Models\PengajuanSurat;
use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'jenis_surat' => 'required|in:' . implode(',', array_keys(PengajuanSurat::jenisSuratList())),
            'tujuan_surat' => 'required|string|max:500',
            'keterangan' => 'nullable|string|max:1000',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_tambahan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_surat.required' => 'Jenis surat wajib dipilih.',
            'tujuan_surat.required' => 'Tujuan surat wajib diisi.',
            'file_ktp.required' => 'File KTP wajib diupload.',
            'file_ktp.max' => 'Ukuran file KTP maksimal 2MB.',
            'file_kk.required' => 'File KK wajib diupload.',
            'file_kk.max' => 'Ukuran file KK maksimal 2MB.',
            'file_tambahan.max' => 'Ukuran file tambahan maksimal 2MB.',
        ];
    }
}
