<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;
use Illuminate\Http\Request;
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
        return view('admin.newsletters.broadcast');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $subscribers = Newsletter::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            SendNewsletterJob::dispatch($subscriber, $validated['subject'], $validated['content']);
        }

        return redirect()->route('admin.newsletters.index')
            ->with('success', "Newsletter broadcast dispatched to {$subscribers->count()} subscribers.");
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return back()->with('success', 'Subscriber removed successfully.');
    }
}
