<?php

namespace App\Http\Controllers\Interaction;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    public function toggle(Post $post): RedirectResponse
    {
        $user = auth()->user();

        if ($user->bookmarkedPosts()->where('post_id', $post->id)->exists()) {
            $user->bookmarkedPosts()->detach($post->id);
            $message = 'Post removed from your library.';
        } else {
            $user->bookmarkedPosts()->attach($post->id);
            $message = 'Post added to your library.';
        }

        return back()->with('success', $message);
    }
}
