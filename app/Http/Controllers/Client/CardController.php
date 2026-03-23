<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Card\SroreRequest;
use App\Http\Resources\Card\CardResource;
use App\Models\Card;
use App\Services\CardService;

class CardController extends Controller
{
    public function index()
    {
        return inertia('Client/Card/Index');
    }

    public function store(SroreRequest $request)
    {
        $data = $request->validated();
        $card = CardService::store($data);
        return CardResource::make($card)->resolve();
    }
}
