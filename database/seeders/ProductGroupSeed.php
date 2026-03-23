<?php

namespace Database\Seeders;

use App\Models\ProductGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductGroup::create([
            'category_id' => 1,
            'title'=>'Верхняя одежда ',
        ]);
        ProductGroup::create([
            'category_id' => 1,
            'title'=>'Обувь',
        ]);
        ProductGroup::create([
            'category_id' => 1,
            'title'=>'Нижняя одежда',
        ]);
    }
}
