<?php

namespace App\Http\Requests\Backsite\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'max:255'],
            'user_type_id' => ['required', 'integer', 'exists:user_types,id'],
            'age' => ['nullable', 'integer'],
            'contact' => ['nullable', 'string', 'max:16'],
            'address' => ['nullable'],
            'photo' => ['nullable', 'file', 'image'],
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
