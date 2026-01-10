<?php

namespace Database\Seeders;

use App\Models\Param;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Param::create([
            'title'=>'Рост',
            'category_id'=>1,
            'filter_type'=>1,
        ]);
        Param::create([
            'title'=>'Размер',
            'category_id'=>1,
            'filter_type'=>3,
        ]);
        Param::create([
            'title'=>'Цвет',
            'category_id'=>1,
            'filter_type'=>3,
            'label'=>'color',
        ]);
        Param::create([
            'title'=>'Материал',
            'category_id'=>1,
            'filter_type'=>2,
        ]);
    }
}
