<?php

namespace App\Models;

use App\Enums\AuthorApplicationStatus;
use Database\Factories\AuthorApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorApplication extends Model
{
    /** @use HasFactory<AuthorApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'portfolio_links',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => AuthorApplicationStatus::class,
            'portfolio_links' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
