<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'currentPage' => 'required|string',
            'sort' => 'required|in:driver_id',
            'delimiter' => 'required|in:asc,desc',
        ];
    }
}
