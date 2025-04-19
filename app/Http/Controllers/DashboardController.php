<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $level = $user->position->level ?? null;
        $logs = collect();
        $divisions = collect();
        $logStats=collect();

        if ($level === 'staff') {
            $logs = Log::where('user_id', $user->id)->latest()->get();

            $logStats = [
                'pending' => Log::where('user_id', $user->id)->where('status', 'pending')->count(),
                'disetujui' => Log::where('user_id', $user->id)->where('status', 'disetujui')->count(),
                'ditolak' => Log::where('user_id', $user->id)->where('status', 'ditolak')->count(),
            ];
        }
        elseif ($level === 'manager') {
            $subordinateIds = $user->subordinates->pluck('id');
            $logs = Log::whereIn('user_id', $subordinateIds)->latest()->get();
        }
        elseif ($level === 'direktur') {
            $divisions = Position::withCount('users')
                ->whereIn('level', ['staff', 'manager'])
                ->get();
        }

        return view('dashboard', compact('user', 'level', 'logs', 'divisions','logStats'));
    }


}