<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Gif>
 */
class GifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::random(14),
            'gif_id' => Str::random(13),
            'alias' => Str::random(4),
            'url' => 'https://giphy.com/gifs/' .Str::random(13),
            'slug' => Str::random(13),
            'title' => Str::random(15),
            'user_id' => 1
        ];
    }

}
