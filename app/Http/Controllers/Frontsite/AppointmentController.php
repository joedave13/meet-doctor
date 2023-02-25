<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('pages.frontsite.appointment.index');
    }
}
