<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = Category::query()->create([
                'title' => "Category $i",
            ]);
            for ($j = 1; $j <= 5; $j++) {
                $category1 = Category::query()->create([
                    'title' => "Category $i.$j",
                    'parent_id' => $category->id,
                ]);
            }
            for ($z = 1; $z <= 5; $z++) {
                $category2 = Category::query()->create([
                    'title' => "Category $i.$j.$z",
                    'parent_id' => $category1->id,
                ]);
            }

        }

    }
}
