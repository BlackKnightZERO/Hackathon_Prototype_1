<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first_name     = fake()->firstName();
        $last_name      = fake()->lastName();
        $username       = $first_name . '-' . rand(1000,99999);
        $slug           = SlugService::createSlug(User::class, 'slug', $first_name, ['unique' => true]);

        return [
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => fake()->unique()->safeEmail(),
            'username'      => $username,
            'password'      => Hash::make('123123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin'      => 0,
            'slug'          => $slug,
            'created_at'    => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
