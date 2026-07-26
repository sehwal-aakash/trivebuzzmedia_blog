<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Mail\BroadcastNewsletter;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function index(): View
    {
        $subscribers = Newsletter::latest()->paginate(50);

        return view('admin.newsletters.index', compact('subscribers'));
    }

    public function create(): View
    {
        $activeSubscribersCount = Newsletter::where('is_active', true)->count();
        $usersCount = User::count();

        return view('admin.newsletters.broadcast', compact('activeSubscribersCount', 'usersCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'audience' => ['required', 'string', 'in:subscribers,users,custom'],
            'custom_emails' => ['nullable', 'string'],
            'send_now' => ['nullable', 'boolean'],
        ]);

        $recipients = collect();

        if ($validated['audience'] === 'subscribers') {
            $recipients = Newsletter::where('is_active', true)->get()->map(function ($sub) {
                return (object) [
                    'email' => $sub->email,
                    'token' => $sub->token,
                ];
            });
        } elseif ($validated['audience'] === 'users') {
            $recipients = User::whereNotNull('email')->get()->map(function ($user) {
                return (object) [
                    'email' => $user->email,
                    'token' => null,
                ];
            });
        } elseif ($validated['audience'] === 'custom') {
            $emails = array_filter(array_map('trim', explode(',', $validated['custom_emails'] ?? '')));
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $recipients->push((object) [
                        'email' => $email,
                        'token' => null,
                    ]);
                }
            }
        }

        if ($recipients->isEmpty()) {
            return back()->withInput()->with('error', 'No valid recipient email addresses were found for the selected audience.');
        }

        $sendNow = $request->boolean('send_now');
        $dispatchedCount = 0;

        foreach ($recipients as $recipient) {
            if ($sendNow) {
                Mail::to($recipient->email)->send(new BroadcastNewsletter($validated['subject'], $validated['content'], $recipient->token));
            } else {
                SendNewsletterJob::dispatch($recipient->email, $validated['subject'], $validated['content'], $recipient->token);
            }
            $dispatchedCount++;
        }

        $methodText = $sendNow ? 'sent immediately' : 'dispatched to background queue';

        return redirect()->route('admin.newsletters.index')
            ->with('success', "Newsletter broadcast successfully {$methodText} to {$dispatchedCount} recipients.");
    }

    public function destroy(Newsletter $newsletter): RedirectResponse
    {
        $newsletter->delete();

        return back()->with('success', 'Subscriber removed successfully.');
    }
}
