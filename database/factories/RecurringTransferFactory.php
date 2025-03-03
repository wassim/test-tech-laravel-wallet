<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecurringTransfer>
 */
class RecurringTransferFactory extends Factory
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
            'recipient_email' => fake()->unique()->safeEmail(),
            'reason' => fake()->sentence(),
            'amount' => fake()->numberBetween(10, 1000000),
            'frequency' => 1,
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
