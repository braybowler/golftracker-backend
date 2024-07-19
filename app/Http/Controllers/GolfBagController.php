<?php

namespace App\Http\Controllers;

use App\Http\Resources\GolfBagResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\GolfBag;

class GolfBagController extends Controller
{
    public function index()
    {
        return GolfBagResource::collection(auth()->user()->golfBags()->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'bail|required|string|max:255',
            'model' => 'bail|required|string|max:255',
            'nickname' => 'string|max:255',
        ]);

        $golfBag = GolfBag::create([
            'user_id' => auth()->id(),
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'nickname' => $request->input('nickname') ?? '',
        ]);

        return response()->json(GolfBagResource::make($golfBag), 201);
    }

    public function show(string $id)
    {
        $golfBag = GolfBag::where('user_id', auth()->id())->findOrFail($id);

        return response()->json(GolfBagResource::make($golfBag));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'make' => 'bail|required|string|max:255',
            'model' => 'bail|required|string|max:255',
            'nickname' => 'string|max:255',
        ]);

        $golfBag = GolfBag::findOrFail($id);

        $golfBag->update([
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'nickname' => $request->input('nickname') ? $request->input('nickname') : '',
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(GolfBagResource::make($golfBag));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([], 201);
    }
}
