<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Notifications\LogStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $level = $user->position->level ?? null;

        if ($user->position->level === 'manager') {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        $query = Log::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->latest()->paginate(10)->withQueryString();

        return view('logs.index', compact('logs', 'level'));
    }



    public function create(){
        if (Auth::user()->position->level === 'manager') {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return view('logs.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'attachment' => 'nullable|mimes:pdf|max:2048',
        ]);

        $validated['user_id'] = Auth::user()->id;

        if ($request->hasFile('attachment')) {
            $originalFilename = $request->file('attachment')->getClientOriginalName();

            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');

            $validated['original_name'] = $originalFilename;
        }

        $validated['status'] = 'pending';

        Log::create($validated);

        return redirect()->route('logs.index')->with('success', 'Log harian berhasil ditambahkan.');
    }

    public function update(Request $request, Log $log)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'attachment' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($log->status === 'ditolak') {
            $validated['status'] = 'pending';

            $currentHistory = $log->revision_history ?? [];

            $currentHistory[] = [
                'last_rejected_at' => $log->updated_at->format('Y-m-d H:i:s'),
                'previous_feedback' => $log->feedback,
                'resubmitted_at' => now()->format('Y-m-d H:i:s'),
            ];

            $validated['revision_history'] = $currentHistory;
            $validated['is_resubmission'] = true;
        }

        if ($request->hasFile('attachment')) {
            if ($log->attachment && Storage::disk('public')->exists($log->attachment)) {
                Storage::disk('public')->delete($log->attachment);
            }

            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
            $validated['original_name'] = $request->file('attachment')->getClientOriginalName();
        }

        $log->update($validated);

        return redirect()->route('logs.index')->with('success', 'Log harian berhasil diperbarui dan dikirim untuk verifikasi ulang.');
    }


    public function show($id){
        $user = Auth::user();

        $log = Log::findOrFail($id);

        if ($user->position->level === 'manager') {
            $subordinateIds = $user->subordinates->pluck('id');

            if (!in_array($log->user_id, $subordinateIds->toArray())) {
                abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
            }
        }

        if ($user->position->level === 'staff' && $log->user_id !== $user->id) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return view('logs.show', compact('log'));
    }


    public function edit(Log $log){
        $user = Auth::user();
        if ($user->position->level === 'manager') {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        if ($user->position->level === 'staff' && $log->user_id !== $user->id) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return view('logs.edit', compact('log'));
    }

    public function destroy(Log $log){
        if ($log->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($log->attachment && Storage::disk('public')->exists($log->attachment)) {
            Storage::disk('public')->delete($log->attachment);
        }

        $log->delete();

        return redirect()->route('logs.index')->with('success', 'Log berhasil dihapus.');
    }

    public function download(Log $log){

        $filePath = storage_path('app/public/' . $log->attachment);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $log->original_name);
    }

    public function verifikasiLog(Request $request)
    {
        $date = $request->query('date');
        $search = $request->query('search');

        if (!$date) {
            $date = now()->toDateString();
        }

        $user = Auth::user();

        if ($user->position->level !== 'manager') {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        if ($user->position->level === 'manager') {
            $subordinateIds = $user->subordinates->pluck('id');

            $logsQuery = Log::with('user')
                ->whereIn('user_id', $subordinateIds)
                ->whereDate('created_at', $date);

            if ($search) {
                $logsQuery->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            }

            $logs = $logsQuery->orderByDesc('created_at')->paginate(10)->withQueryString(); // paginasi + query string agar search & date tetap terbawa
        }

        return view('logs.verification-log', compact('logs', 'date', 'search'));
    }



    public function approved(Log $log)
    {
        $log->status = 'disetujui';
        $log->save();

        $log->user->notify(new LogStatusNotification($log, 'disetujui'));

        return back()->with('success', 'Log disetujui.');
    }

    public function rejected(Request $request, Log $log)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $log->update([
            'status' => 'ditolak',
            'feedback' => $validated['feedback'],
        ]);

        $log->user->notify(new LogStatusNotification($log, 'ditolak'));

        return back()->with('success', 'Log ditolak dengan catatan.');
    }


}
