<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfficeRequest extends FormRequest
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
            'office_name' => ['required', 'string'],
            'region' => ['string'],
            'type' => ['required', 'string', 'in:head_office,support_office,job_site'],
        ];
    }
}
