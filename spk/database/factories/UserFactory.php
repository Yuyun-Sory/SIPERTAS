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
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),  ← hapus/comment baris ini
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }
}