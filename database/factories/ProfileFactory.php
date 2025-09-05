<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'display_name' => fake()->firstName() . ' ' . fake()->lastName(),
            'age' => fake()->numberBetween(18, 65),
            'city' => fake()->city(),
            'address' => fake()->streetAddress(),
            'about' => fake()->paragraph(3),
            'availability_hours' => [
                'Monday' => '9:00-17:00',
                'Tuesday' => '9:00-17:00',
                'Wednesday' => '9:00-17:00',
                'Thursday' => '9:00-17:00',
                'Friday' => '9:00-17:00',
            ],
            'status' => fake()->randomElement(['draft', 'pending', 'approved', 'rejected']),
            'is_public' => fake()->boolean(80), // 80% chance of being public
            'verified_at' => fake()->boolean(60) ? now()->subDays(fake()->numberBetween(1, 30)) : null,
        ];
    }

    /**
     * Indicate that the profile is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the profile is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Indicate that the profile is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }
}
