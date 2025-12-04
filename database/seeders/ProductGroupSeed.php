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
            'title'=>'Футболка',
        ]);
        ProductGroup::create([
            'title'=>'Брюки',
        ]);
        ProductGroup::create([
            'title'=>'Бриджи',
        ]);
    }
}
