<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Ministry;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ministry>
 */
class MinistryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title  = fake()->unique()->word();
        $slug   = SlugService::createSlug(Ministry::class, 'slug', $title, ['unique' => true]);

        return [
            'title'         => $title,
            'short_title'   => Str::substr((Str::upper($title)), 0,4),
            'description'   => fake()->unique()->sentence(),
            'created_at'    => now(),
            'slug'          => $slug,
        ];
    }
}
