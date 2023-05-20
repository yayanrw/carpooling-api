<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleBookingRequest extends FormRequest
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
            'vehicle_id' => ['required', Rule::exists('m_vehicle', 'id')],
            'driver_id' => ['required', Rule::exists('users', 'id')],
            'user_request_id' => ['required', Rule::exists('users', 'id')],
            'estimation_start_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'estimation_completion_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'neccesary' => ['string'],
        ];
    }
}
