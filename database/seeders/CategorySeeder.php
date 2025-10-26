<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'image' => '/image-categories/book.png'
            ],
            [
                'name' => 'Sosial',
                'slug' => 'sosial',
                'image' => '/image-categories/hand.png'
            ],
            [
                'name' => 'Bencana Alam',
                'slug' => 'bencana-alam',
                'image' => '/image-categories/fire.png'
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'image' => '/image-categories/medic.png'
            ],
            [
                'name' => 'Lingkungan',
                'slug' => 'lingkungan',
                'image' => '/image-categories/leaf.png'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
