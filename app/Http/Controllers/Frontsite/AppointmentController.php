<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontsite\Appointment\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Doctor $doctor)
    {
        $consultations = Consultation::all();

        return view('pages.frontsite.appointment.index', compact('doctor', 'consultations'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);

            $data['user_id'] = auth()->id();
            $data['date'] = date('Y-m-d', strtotime($request->date));
            $data['time'] = date('H:i:s', strtotime(explode(' ', $request->time)[0]));

            $appointment = Appointment::query()->create($data);

            DB::commit();

            toast('Appointment created successfully!', 'success');
            return redirect()->route('payment', $appointment->id);
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
