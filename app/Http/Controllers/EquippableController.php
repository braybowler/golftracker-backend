<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaggableRequest;
use App\Http\Requests\EquippableRequest;
use App\Http\Resources\BaggableResource;
use App\Http\Resources\EquippableResource;
use App\Models\Baggable;
use App\Models\Equippable;
use App\Models\GolfClub;

class EquippableController extends Controller
{
    public function index()
    {
    }

    public function store(EquippableRequest $request)
    {
        $equippable = Equippable::create([
            'user_id' => $request->validated('user.id'),
            'equippable_id' => $request->validated('equippable.id'),
            'equippable_type' =>$request->validated('equippable.type'),
        ]);

        return response()->json(EquippableResource::make($equippable), 201);
    }

    public function show(string $id)
    {
    }

    public function update(BaggableRequest $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
