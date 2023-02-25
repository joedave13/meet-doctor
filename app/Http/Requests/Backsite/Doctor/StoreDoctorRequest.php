<?php

namespace App\Http\Requests\Backsite\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'specialist_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'fee' => ['required', 'integer'],
            'photo' => ['nullable', 'file', 'image']
        ];
    }
}
