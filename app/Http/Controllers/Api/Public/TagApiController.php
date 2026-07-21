<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::withCount('posts')->latest()->get();

        return TagResource::collection($tags);
    }
}
