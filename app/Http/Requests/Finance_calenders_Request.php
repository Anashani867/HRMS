<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Finance_calenders_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array 
    {
        return [
            'FINANCE_YR' => 'required|unique:finance_calenders',
            'FINANCE_YR_DESC' => 'required',
            'start_date' => 'required|date', // التأكد من أن start_date هو تاريخ صالح
            'end_date' => 'required|date|after:start_date', // التأكد من أن end_date أكبر من start_date
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'FINANCE_YR.required' => 'كود السنة المالية مطلوب',
            'FINANCE_YR.unique' => 'كود السنة مسجل من قبل',
            'FINANCE_YR_DESC.required' => 'وصف السنة المالية مطلوب',
            'start_date.required' => 'تاريخ بداية السنة المالية مطلوب',
            'start_date.date' => 'تاريخ بداية السنة المالية يجب أن يكون بتاريخ صالح',
            'end_date.required' => 'تاريخ نهاية السنة المالية مطلوب',
            'end_date.date' => 'تاريخ نهاية السنة المالية يجب أن يكون بتاريخ صالح',
            'end_date.after' => 'تاريخ نهاية السنة المالية يجب أن يكون بعد تاريخ بداية السنة المالية',
        ];
    }
}

