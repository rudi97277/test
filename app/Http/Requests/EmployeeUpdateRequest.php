<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
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
        $id = $this->route('employee');

        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => [
                'string',
                Rule::unique('employees')->ignore($id),
            ],
            'phone_number' => [
                'string',
                Rule::unique('employees')->ignore($id),
            ],
            'address' => 'string',
            'gender' => 'in:male,female'
        ];
    }
}
