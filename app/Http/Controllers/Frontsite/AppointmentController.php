<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Doctor $doctor)
    {
        return view('pages.frontsite.appointment.index', compact('doctor'));
    }
}
