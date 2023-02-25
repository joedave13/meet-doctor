<?php

namespace App\Http\Requests\Backsite\Consultation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConsultationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('consultations')->ignore($this->consultation)],
            'level' => ['required', 'integer', Rule::in([1, 2, 3])],
            'fee' => ['required', 'integer']
        ];
    }
}
