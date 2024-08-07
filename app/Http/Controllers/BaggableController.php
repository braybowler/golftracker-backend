<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaggableRequest;
use App\Http\Resources\BaggableResource;
use App\Models\Baggable;
use App\Models\GolfClub;

class BaggableController extends Controller
{
    public function index()
    {
        //TODO: Any baggable in any of the users bags, or any baggable in a specific bag?
    }

    public function store(BaggableRequest $request)
    {
        $baggable = Baggable::create([
            'golf_bag_id' => $request->validated('bag.id'),
            'baggable_id' => $request->validated('baggable.id'),
            'baggable_type' =>$request->validated('baggable.type'),
        ]);

        return response()->json(BaggableResource::make($baggable), 201);
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
