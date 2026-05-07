<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(): View
    {
        $posts = auth()->user()->bookmarkedPosts()
            ->with(['author', 'category'])
            ->latest('bookmarks.created_at')
            ->paginate(12);

        return view('user.library.index', compact('posts'));
    }
}
