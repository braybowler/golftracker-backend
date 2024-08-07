<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolfBagRequest;
use App\Http\Resources\GolfBagResource;
use App\Models\GolfBag;
use Carbon\Carbon;

class GolfBagController extends Controller
{
    public function index()
    {
        return GolfBagResource::collection(auth()->user()->golfBags()->paginate(10));
    }

    public function store(GolfBagRequest $request)
    {
        $golfBag = GolfBag::create([
            'user_id' => auth()->id(),
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
            'nickname' => $request->validated('nickname') ?? '',
        ]);

        return response()->json(GolfBagResource::make($golfBag), 201);
    }

    public function show(string $id)
    {
        $golfBag = GolfBag::where('user_id', auth()->id())->findOrFail($id);

        return response()->json(GolfBagResource::make($golfBag));
    }

    public function update(GolfBagRequest $request, string $id)
    {
        $golfBag = GolfBag::where('user_id', auth()->id())->findOrFail($id);

        $golfBag->update([
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
            'nickname' => $request->validated('nickname') ?: '',
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(GolfBagResource::make($golfBag));
    }

    public function destroy(string $id)
    {
        $golfBag = GolfBag::where('user_id', auth()->id())->findOrFail($id);

        $golfBag->delete();

        return response()->json([], 204);
    }
}
