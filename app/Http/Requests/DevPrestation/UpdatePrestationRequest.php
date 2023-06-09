<?php

namespace App\Http\Requests\DevPrestation;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrestationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prestation_type_id' => 'nullable|exists:prestation_types,id',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|int',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'prestation_type_id.exists' => 'Le type de prestation n\'existe pas',
            'description.max' => 'La description ne doit pas dépasser 255 caractères',
            'description.string' => 'La description doit être une chaîne de caractères',
            'price.int' => 'Le prix doit être un nombre entier',
        ];
    }
}
