<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaggableRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bag.id' => 'required|integer|exists:golf_bags,id',
            'baggable.id' => 'required|integer',
            'baggable.type' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
