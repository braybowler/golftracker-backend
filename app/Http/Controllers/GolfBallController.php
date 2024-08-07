<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolfBallRequest;
use App\Http\Resources\GolfBallResource;
use App\Models\GolfBall;
use Carbon\Carbon;

class GolfBallController extends Controller
{
    public function index()
    {
        return GolfBallResource::collection(auth()->user()->golfBalls()->paginate(10));
    }

    public function store(GolfBallRequest $request)
    {
        $validated = $request->safe()->all();

        $golfBall = GolfBall::create([
            'user_id' => auth()->id(),
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
        ]);

        return response()->json(GolfBallResource::make($golfBall), 201);
    }

    public function show(string $id)
    {
        $golfBall = GolfBall::where('user_id', auth()->id())->findOrFail($id);

        return response()->json(GolfBallResource::make($golfBall));
    }

    public function update(GolfBallRequest $request, string $id)
    {
        $golfBall = GolfBall::where('user_id', auth()->id())->findOrFail($id);

        $golfBall->update([
            'make' => $request->validated('make'),
            'model' => $request->validated('model'),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(GolfBallResource::make($golfBall));
    }

    public function destroy(string $id)
    {
        $golfBall = Golfball::where('user_id', auth()->id())->findOrFail($id);

        $golfBall->delete();

        return response()->json([], 204);
    }
}
