<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailLogController extends Controller
{
    /**
     * Display a listing of email logs for Super Admins.
     */
    public function index(Request $request): View
    {
        if (! $request->user()?->isSuperAdmin()) {
            abort(403, 'Unauthorized access to Email Logs. Super Admin access required.');
        }

        $query = EmailLog::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('body_snippet', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $stats = [
            'total_sent' => EmailLog::count(),
            'sent_today' => EmailLog::whereDate('created_at', today())->count(),
            'failed_count' => EmailLog::where('status', 'failed')->count(),
            'success_rate' => EmailLog::count() > 0
                ? round((EmailLog::where('status', 'sent')->count() / EmailLog::count()) * 100, 1)
                : 100,
        ];

        $logs = $query->latest()->paginate(15)->withQueryString();

        return view('admin.email-logs.index', compact('logs', 'stats'));
    }

    /**
     * Remove the specified email log.
     */
    public function destroy(Request $request, EmailLog $emailLog): RedirectResponse
    {
        if (! $request->user()?->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $emailLog->delete();

        return back()->with('success', 'Email log entry deleted successfully.');
    }

    /**
     * Purge all email logs.
     */
    public function purge(Request $request): RedirectResponse
    {
        if (! $request->user()?->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        EmailLog::truncate();

        return back()->with('success', 'All email logs have been purged successfully.');
    }
}
