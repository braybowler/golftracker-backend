<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaggableRequest extends FormRequest
{
    public function rules(): array
    {
        //What should validation rules be for a Baggable?
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }
}
