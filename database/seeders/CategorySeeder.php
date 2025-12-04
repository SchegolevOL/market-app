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

            $category1 = Category::query()->create([
                'title' => "Одежда",
            ]);
            $category2 = Category::query()->create([
                'parent_id' => $category1->id,
                'title' => "Женская одежда",
            ]);
            $category3 = Category::query()->create([
                'parent_id' => $category1->id,
                'title' => "Мужская одежда",
            ]);



    }
}
