<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FavoriteGifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Gif::factory()->create([
            'uuid' => '662bb94e8da43',
            'gif_id' => 'GVaknm5baLdAc',
            'alias' => 'Test',
            'url' => 'https://giphy.com/gifs/GVaknm5baLdAc',
            'slug' => 'GVaknm5baLdAc',
            'title' => 'hamburgers GIF',
            'user_id' => 1
        ]);
    }
}
