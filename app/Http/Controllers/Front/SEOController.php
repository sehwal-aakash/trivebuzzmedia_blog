<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Response;

class SEOController extends Controller
{
    public function sitemap(): Response
    {
        $posts = Post::published()->latest()->get();
        $categories = Category::all();
        $tags = Tag::all();

        $content = view('public.sitemap', compact('posts', 'categories', 'tags'));

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Allow: /posts/\n";
        $content .= "Allow: /category/\n";
        $content .= "Allow: /tag/\n";
        $content .= "Allow: /about\n";
        $content .= "Allow: /contact\n";
        $content .= "Allow: /help\n";
        $content .= "Allow: /privacy\n";
        $content .= "Allow: /terms\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /author/\n";
        $content .= "Disallow: /search\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /forgot-password\n";
        $content .= "Disallow: /reset-password\n\n";
        $content .= 'Sitemap: '.route('sitemap')."\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
