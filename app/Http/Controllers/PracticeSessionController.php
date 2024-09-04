<?php

namespace App\Http\Controllers;

use App\Http\Requests\PracticeSessionRequest;
use App\Http\Resources\PracticeSessionResource;
use App\Models\PracticeSession;
use Carbon\Carbon;

class PracticeSessionController extends Controller
{
    public function index()
    {
        return PracticeSessionResource::collection(auth()->user()->practiceSessions()->paginate(10));
    }

    public function store(PracticeSessionRequest $request)
    {
        $practiceSession = PracticeSession::create([
            'user_id' => auth()->user()->id,
            'date' => $request->validated('date'),
            'note' => $request->validated('note'),
            'start_time' => $request->validated('start_time'),
            'end_time' => $request->validated('end_time'),
            'temperature' => $request->validated('temperature'),
            'wind_speed' => $request->validated('wind_speed'),
        ]);
        return response()->json(PracticeSessionResource::make($practiceSession), 201);
    }

    public function show(string $id)
    {
        $practiceSession = PracticeSession::where('user_id', auth()->id())->findOrFail($id);

        return response()->json(PracticeSessionResource::make($practiceSession));
    }

    public function update(PracticeSessionRequest $request, string $id)
    {
        $practiceSession = PracticeSession::where('user_id', auth()->id())->findOrFail($id);

        $practiceSession->update([
            'date' => $request->validated('date'),
            'note' => $request->validated('note'),
            'start_time' => $request->validated('start_time'),
            'end_time' => $request->validated('end_time'),
            'temperature' => $request->validated('temperature'),
            'wind_speed' => $request->validated('wind_speed'),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(PracticeSessionResource::make($practiceSession));
    }

    public function destroy(PracticeSession $practiceSession)
    {
        $practiceSession->delete();

        return response()->json();
    }
}
