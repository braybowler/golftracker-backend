<?php

namespace App\Http\Controllers;

use App\Http\Requests\PracticeSessionRequest;
use App\Http\Resources\PracticeSessionResource;
use App\Models\PracticeSession;

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

    public function show(PracticeSession $practiceSession)
    {
        return new PracticeSessionResource($practiceSession);
    }

    public function update(PracticeSessionRequest $request, PracticeSession $practiceSession)
    {
        $practiceSession->update($request->validated());

        return new PracticeSessionResource($practiceSession);
    }

    public function destroy(PracticeSession $practiceSession)
    {
        $practiceSession->delete();

        return response()->json();
    }
}
