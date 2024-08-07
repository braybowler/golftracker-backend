<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaggableRequest;
use App\Http\Resources\BaggableResource;
use App\Models\Baggable;

class BaggableController extends Controller
{
    public function index()
    {
        //TODO: Any baggable in any of the users bags, or any baggable in a specific bag?
    }

    public function store(BaggableRequest $request)
    {
        $validated = $request->safe()->all(); //TODO: build validation for a BaggableRequest

        $baggable = Baggable::create([
            'golf_bag_id' => $validated['bag']['golf_bag_id'],
            'baggable_id' => $validated['baggable']['id'],
            'baggable_type' => $validated['baggable']['type'], //TODO: type isnt a field in the request. How do I type this dynamically?
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
