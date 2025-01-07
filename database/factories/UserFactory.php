<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'first_name' => fake()->name(),
        'last_name' => fake()->lastName(),
        // 'role' => fake()->randomElement(['admin', 'user', 'editor']),
        'position' => fake()->randomElement(['student', 'trainer', 'administrator']),
        'email' => fake()->unique()->safeEmail(),
        'phone' => fake()->phoneNumber(),
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
        // 'age' => fake()->numberBetween(18, 65),
        // 'profile_image_url' => fake()->imageUrl(640, 480, 'people', true, 'Faker'),
        // 'street' => fake()->streetAddress(),
        // 'street_2' => fake()->secondaryAddress(),
        // 'district' => fake()->citySuffix(),
        // 'city' => fake()->city(),
        // 'province' => fake()->state(),
        // 'postal_code' => fake()->postcode(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
