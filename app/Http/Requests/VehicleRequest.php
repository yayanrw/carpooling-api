<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_id' => ['required', Rule::exists('m_company', 'id')],
            'office_id' => ['required', Rule::exists('m_office', 'id')],
            'license_plate' => ['required', 'string', 'unique:m_vehicle,license_plate'],
            'hull_number' => ['required', 'string', 'unique:m_vehicle,hull_number'],
            'type' => ['required', 'in:man_haul,goods_haul']
        ];
    }
}
