<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = Newsletter::firstOrNew(['email' => $request->email]);

        if ($subscriber->is_active) {
            return back()->with('info', 'You are already subscribed to our newsletter.');
        }

        $subscriber->is_active = true;
        $subscriber->token = Str::random(32);
        $subscriber->subscribed_at = now();
        $subscriber->save();

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function unsubscribe(string $token): RedirectResponse
    {
        $subscriber = Newsletter::where('token', $token)->firstOrFail();

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
            'token' => null,
        ]);

        return redirect()->route('home')->with('success', 'You have been successfully unsubscribed.');
    }
}
