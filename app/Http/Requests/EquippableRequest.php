<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquippableRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user.id' => 'required|integer|exists:users,id',
            'equippable.id' => 'required|integer',
            'equippable.type' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
