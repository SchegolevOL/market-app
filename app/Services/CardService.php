<?php

namespace App\Services;

use App\Models\Card;

use Illuminate\Support\Facades\DB;

class CardService
{

    public static function store(array $data)
    {

        $card = auth()->user()->cards()->create($data);

        return $card;
    }

    public static function update(Card $card, array $data)
    {

        $category->update($data['category']);
        ImageService::storeBatch($category, $data['images']);
        return $category->fresh();
    }



    public static function delete(Card $card)
    {


    }





}
