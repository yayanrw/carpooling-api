<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleBookingRequest extends FormRequest
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
            'actual_start_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'actual_completion_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'status' => ['required', 'in:on_approval,ready_for_use,on_use,finished,rejected,no_driver,no_vehicle'],
        ];
    }
}
