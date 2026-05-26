<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('search')) {
            $query->where('aktivitas', 'like', "%{$request->search}%")
                ->orWhere('deskripsi', 'like', "%{$request->search}%");
        }

        if ($request->filled('aktivitas')) {
            $query->where('aktivitas', $request->aktivitas);
        }

        $logs = $query->latest('created_at')->paginate(20);

        return view('admin.history.index', compact('logs'));
    }
}
