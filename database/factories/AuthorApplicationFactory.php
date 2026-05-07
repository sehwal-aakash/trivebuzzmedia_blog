<?php

namespace Database\Factories;

use App\Enums\AuthorApplicationStatus;
use App\Models\AuthorApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuthorApplication>
 */
class AuthorApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => fake()->paragraph(),
            'portfolio_links' => [
                'https://github.com/'.fake()->userName(),
                'https://linkedin.com/in/'.fake()->userName(),
            ],
            'status' => AuthorApplicationStatus::PENDING,
        ];
    }
}
