<?php

namespace App\Http\Requests\Frontsite\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'consultation_id' => ['required', 'integer', 'exists:consultations,id'],
            'date' => ['required', 'date'],
            'time' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'consultation_id.required' => ['Topik konsultasi harus dipilih!'],
            'date.required' => ['Tanggal harus dipilih!'],
            'date.date' => ['Format tanggal tidak valid!'],
            'time.required' => ['Waktu harus dipilih!'],
        ];
    }
}
