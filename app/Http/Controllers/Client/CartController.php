<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Cart\StoreRequest;
use App\Http\Resources\Cart\CardResource;
use App\Models\Cart;
use App\Services\CartService;

class CartController extends Controller
{
    public function index()
    {
        return inertia('Client/Card/Index');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $card = CartService::store($data);
        return CardResource::make($card)->resolve();
    }
}
