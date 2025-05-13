<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Color;
use App\Models\Size;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call other seeders
        $this->call([
            SubjectSeeder::class,
            StreamSeeder::class,
            ClassroomSeeder::class,
        ]);

        // Seed colors
        $colors = [
            ['color_id' => 1, 'color_name' => 'RED'],
            ['color_id' => 2, 'color_name' => 'YELLOW'],
            ['color_id' => 3, 'color_name' => 'PURPLE'],
            ['color_id' => 4, 'color_name' => 'BLUE'],
            ['color_id' => 5, 'color_name' => 'GREEN'],
            ['color_id' => 6, 'color_name' => 'ORANGE'],
        ];

        foreach ($colors as $color) {
            Color::updateOrCreate(['color_id' => $color['color_id']], $color);
        }

        // Seed sizes
        $sizes = [
            ['size_id' => 1, 'size_label' => '2XS'],
            ['size_id' => 2, 'size_label' => 'XS'],
            ['size_id' => 3, 'size_label' => 'S'],
            ['size_id' => 4, 'size_label' => 'M'],
            ['size_id' => 5, 'size_label' => 'L'],
            ['size_id' => 6, 'size_label' => 'XL'],
            ['size_id' => 7, 'size_label' => '2XL'],
            ['size_id' => 8, 'size_label' => '3XL'],
            ['size_id' => 9, 'size_label' => '4XL'],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['size_id' => $size['size_id']], $size);
        }
    }
}
