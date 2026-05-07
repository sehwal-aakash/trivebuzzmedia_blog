<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SEOMeta extends Model
{
    protected $table = 'seo_metas';

    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'canonical_url',
        'extra_meta',
    ];

    protected $casts = [
        'extra_meta' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
