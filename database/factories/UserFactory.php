<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nik' => fake()->unique()->numerify('################'),
            'phone' => fake()->numerify('08##########'),
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }
}
