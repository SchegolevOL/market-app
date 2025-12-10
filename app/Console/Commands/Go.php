<?php

namespace App\Console\Commands;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Go extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $value = 's';
        $value = Str::lower($value);
        $types = [];
        $enum = ParamFilterTypeEnum::map();

        for ($i=1; $i<=count($enum); $i++) {
            if(str_contains($enum[$i], $value)){
                $types[] = $i;
            }
        }
        dd($types);


    }
}
