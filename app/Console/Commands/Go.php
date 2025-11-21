<?php

namespace App\Console\Commands;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Category;
use App\Models\Image;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Console\Command;

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
        $category = Category::query()->find(5);

        $res = CategoryService::breadcrumbs($category, []);



        dd($res);
    }
}
