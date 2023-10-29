<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AirportValidationService
{
    public function validateAirport($data, $id = null)
    {
        $rules = [
            'iata_code' => ($id ? 'sometimes' : 'required') . '|max:3|unique:airports,iata_code' . ($id ? ',' . $id : ''),
            'latitude' => ($id ? 'sometimes' : 'required') . '|numeric|between:-90,90',
            'longitude' => ($id ? 'sometimes' : 'required') . '|numeric|between:-180,180',
            'terms_conditions' => 'nullable|string',
            'translations' => 'sometimes|array',
            'translations.*.language_code' => 'required_with:translations.*|string|max:2',
            'translations.*.name' => 'required_with:translations.*|string|max:255',
            'translations.*.description' => 'nullable|string'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $data;
    }
}
