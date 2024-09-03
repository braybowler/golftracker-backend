<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PracticeSessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'bail|required|date',
            'note' => 'sometimes|nullable',
            'start_time' => 'sometimes|nullable|date',
            'end_time' => 'sometimes|nullable|date',
            'temperature' => 'sometimes|nullable|integer',
            'wind_speed' => 'sometimes|nullable|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
