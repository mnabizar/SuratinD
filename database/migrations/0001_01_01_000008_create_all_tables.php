<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ========== USERS TABLE ==========
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik', 16)->nullable()->unique();
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'kepala_desa', 'user'])->default('user');
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // ========== PASSWORD RESET TOKENS ==========
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // ========== SESSIONS ==========
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // ========== PENDUDUK TABLE ==========
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('agama');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('golongan_darah', 5)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // ========== PENGAJUAN SURAT TABLE ==========
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('jenis_surat');
            $table->text('tujuan_surat')->nullable();
            $table->text('keterangan')->nullable();
            $table->json('file_pendukung')->nullable();
            $table->enum('status', ['pending', 'diproses', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

        // ========== SURAT TABLE ==========
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_surat')->nullOnDelete();
            $table->string('jenis_surat');
            $table->longText('isi_surat')->nullable();
            $table->string('verification_code')->unique();
            $table->date('tanggal_terbit');
            $table->enum('status', ['draft', 'diterbitkan', 'dibatalkan'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // ========== VERIFICATION LOGS TABLE ==========
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->enum('status', ['valid', 'tidak_valid']);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // ========== AUDIT LOGS TABLE ==========
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('aktivitas');
            $table->text('deskripsi')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // ========== SETTINGS TABLE ==========
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa')->default('Desa Contoh');
            $table->string('kecamatan')->default('Kecamatan Contoh');
            $table->string('kabupaten')->default('Kabupaten Contoh');
            $table->string('provinsi')->default('Provinsi Contoh');
            $table->string('logo')->nullable();
            $table->string('secret_key')->default('suratind-secret-2024');
            $table->string('alamat_desa')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        // ========== CACHE TABLE ==========
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // ========== JOBS TABLE ==========
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('verification_logs');
        Schema::dropIfExists('surat');
        Schema::dropIfExists('pengajuan_surat');
        Schema::dropIfExists('penduduk');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
