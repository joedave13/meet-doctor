<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontsite\Payment\StorePaymentRequest;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Appointment $appointment)
    {
        return view('pages.frontsite.payment.index', compact('appointment'));
    }

    public function store(StorePaymentRequest $request, Appointment $appointment)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);

            $data['code'] = 'PAY-' . strtoupper(uniqid()) . '-' . $appointment->id;
            $data['appointment_id'] = $appointment->id;
            $data['consultation_fee'] = $appointment->consultation->fee;
            $data['doctor_fee'] = $appointment->doctor->fee;
            $data['hospital_fee'] = 10;
            $data['vat'] = ($appointment->consultation->fee + $appointment->doctor->fee + 10) * 0.1;
            $data['total'] = ($appointment->consultation->fee + $appointment->doctor->fee + 10 + (($appointment->consultation->fee + $appointment->doctor->fee + 10) * 0.1));

            Payment::query()->create($data);

            $appointment->update(['status' => 2]);

            DB::commit();

            toast('Payment successfully created!', 'success');
            return redirect()->route('payment.success');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
