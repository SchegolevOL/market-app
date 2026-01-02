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
            'filter_type'=>1,
        ]);
        Param::create([
            'title'=>'Размер',
            'filter_type'=>3,
        ]);
        Param::create([
            'title'=>'Цвет',
            'filter_type'=>3,
            'label'=>'color',
        ]);
        Param::create([
            'title'=>'Материал',
            'filter_type'=>2,
        ]);
    }
}
