<?php

namespace App\Services;

use App\Models\Card;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartService
{

    public static function store(array $data)
    {

        $cart = auth()->user()->carts()->create($data);

        return $cart;
    }

    public static function update(Cart $cart, array $data)
    {


    }



    public static function delete(Cart $card)
    {


    }





}
