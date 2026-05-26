<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::getInstance();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'secret_key' => 'required|string|min:10',
        ]);

        $setting = Setting::getInstance();
        $data = $request->only('nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'secret_key');

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        $data['updated_at'] = now();
        $setting->update($data);

        AuditLogService::log('Update Pengaturan', 'Mengubah pengaturan sistem');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function backup()
    {
        try {
            $filename = 'backup-' . now()->format('Y-m-d-His') . '.sql';
            $path = storage_path("app/backups/{$filename}");

            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $command = sprintf(
                'mysqldump -u%s -p%s %s > %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                $path
            );

            exec($command);

            AuditLogService::log('Backup Database', "Backup database: {$filename}");

            return response()->download($path)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }
}
