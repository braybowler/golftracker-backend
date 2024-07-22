<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolfClubRequest;
use App\Http\Resources\GolfClubResource;
use App\Models\GolfClub;
use Carbon\Carbon;

class GolfClubController extends Controller
{
    public function index()
    {
        return GolfClubResource::collection(auth()->user()->golfClubs()->paginate(10));
    }

    public function store(GolfClubRequest $request)
    {
        $validated = $request->safe()->all();

        $golfClub = GolfClub::create([
            'user_id' => auth()->id(),
            'make' => $validated['make'],
            'model' => $validated['model'],
            'carry_distance' => $validated['carry_distance'],
            'total_distance' => $validated['total_distance'],
            'loft' => $validated['loft'],
        ]);

        return response()->json(GolfClubResource::make($golfClub), 201);
    }

    public function show(string $id)
    {
        $golfClub = GolfClub::where('user_id', auth()->id())->findOrFail($id);

        return response()->json(GolfClubResource::make($golfClub));
    }

    public function update(GolfClubRequest $request, string $id)
    {
        $validated = $request->safe()->all();

        $golfClub = GolfClub::where('user_id', auth()->id())->findOrFail($id);

        $golfClub->update([
            'make' => $validated['make'],
            'model' => $validated['model'],
            'carry_distance' => $validated['carry_distance'] ?: null,
            'total_distance' => $validated['total_distance'] ?: null,
            'loft' => $validated['loft'] ?: null,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(GolfClubResource::make($golfClub));
    }

    public function destroy(string $id)
    {
        $golfClub = GolfClub::where('user_id', auth()->id())->findOrFail($id);

        $golfClub->delete();

        return response()->json([], 204);
    }
}
