<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolfClubRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'make' => 'bail|required|string|max:255',
            'model' => 'bail|required|string|max:255',
            'club_category' => 'bail|required',
            'club_type' => 'bail|required',
            'carry_distance' => 'sometimes|nullable|integer',
            'total_distance' => 'sometimes|nullable|integer',
            'loft' => 'sometimes|nullable|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
