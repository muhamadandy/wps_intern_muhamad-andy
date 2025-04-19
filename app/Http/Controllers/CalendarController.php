<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function getLogsForCalendar()
    {
        $manager = Auth::user();

        $subordinateIds = $manager->subordinates->pluck('id')->toArray();

        $logs = Log::whereIn('user_id', $subordinateIds)
                  ->get();

        $logsByDate = $logs->groupBy(function($log) {
            return $log->created_at->format('Y-m-d');
        });

        $events = [];

        foreach ($logsByDate as $date => $dateLog) {
            $hasRejected = $dateLog->contains('status', 'ditolak');

            $hasPending = !$hasRejected && $dateLog->contains('status', 'pending');

            $status = $hasRejected ? 'ditolak' : ($hasPending ? 'pending' : 'disetujui');

            $logCount = $dateLog->count();

            $events[] = [
                'title' => $logCount . ' Log',
                'start' => $date,
                'status' => $status,
                'contains_rejected' => $hasRejected,
                'contains_pending' => $hasPending,
                'allDay' => true
            ];
        }

        return response()->json($events);
    }
}