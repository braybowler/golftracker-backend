<?php

namespace App\Http\Controllers;

use App\Http\Resources\GolfBagResource;
use Illuminate\Http\Request;
use App\Models\GolfBag;

class GolfBagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GolfBagResource::collection(auth()->user()->golfBags()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'make' => 'bail|required|string|max:255',
            'model' => 'bail|required|string|max:255',
            'nickname' => 'string|max:255',
        ]);

        //Link this golf bag to the authed user.
        $golfBag = GolfBag::create([
            'user_id' => auth()->id(),
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'nickname' => $request->input('nickname') ?? '',
        ]);

        return response()->json(GolfBagResource::make($golfBag), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([], 201);
    }
}
