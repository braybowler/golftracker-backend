<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolfBagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'make' => 'bail|required|string|max:255',
            'model' => 'bail|required|string|max:255',
            'nickname' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
