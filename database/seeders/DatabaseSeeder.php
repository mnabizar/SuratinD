<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Muhammad Dava',
            'email' => 'admin@suratind.com',
            'nik' => '1234567890123456',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Kepala Desa
        User::create([
            'name' => 'H. Ahmad Surya',
            'email' => 'kades@suratind.com',
            'nik' => '1234567890123457',
            'phone' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => 'kepala_desa',
        ]);

        // Create Sample User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@suratind.com',
            'nik' => '1234567890123458',
            'phone' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Create Settings
        Setting::create([
            'nama_desa' => 'Desa Sukamaju',
            'kecamatan' => 'Kecamatan Ciputra',
            'kabupaten' => 'Kabupaten Bogor',
            'provinsi' => 'Jawa Barat',
            'secret_key' => 'suratind-desa-sukamaju-2024-secret',
            'alamat_desa' => 'Jl. Raya Sukamaju No. 1',
            'kode_pos' => '16710',
            'telepon' => '0251-1234567',
            'updated_at' => now(),
        ]);

        // Create Sample Penduduk
        Penduduk::factory(50)->create(['created_by' => 1]);

        // Create penduduk matching sample user
        Penduduk::create([
            'nik' => '1234567890123458',
            'no_kk' => '1234567890123400',
            'nama' => 'Budi Santoso',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Melati No. 10, RT 03/RW 05, Desa Sukamaju',
            'pekerjaan' => 'Wiraswasta',
            'pendidikan' => 'S1',
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'golongan_darah' => 'O',
            'created_by' => 1,
        ]);

        $this->call([
            SamplePengajuanSeeder::class,
        ]);
    }
}
