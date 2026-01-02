<?php

namespace App\Console\Commands;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
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
        $path = 'ihbticutxuykvbkjbivr/btvt/vuv/b8y7vyv.jpg';

        $extension = array_slice(explode('.', $path),-1);
        $name = bin2hex(random_bytes(16));



        dd($name.'.'.$extension[0]);

    }
}
