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
        return GolfClubResource::collection(auth()->user()->golfClubs()->paginate(15));
    }

    public function store(GolfClubRequest $request)
    {
        $golfClub = GolfClub::create([
            'user_id' => auth()->id(),
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
            'club_category' => $request->validated('club_category'),
            'club_type' => $request->validated('club_type'),
            'carry_distance' => $request->validated('carry_distance'),
            'total_distance' => $request->validated('total_distance'),
            'loft' => $request->validated('loft'),
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
        $golfClub = GolfClub::where('user_id', auth()->id())->findOrFail($id);

        $golfClub->update([
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
            'carry_distance' => $request->validated('carry_distance') ?: null,
            'total_distance' => $request->validated('total_distance') ?: null,
            'loft' => $request->validated('loft') ?: null,
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
