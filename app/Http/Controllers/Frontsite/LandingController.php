<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialist;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $specialists = Specialist::query()->withCount('doctors')->inRandomOrder()->limit(5)->get();
        $doctors = Doctor::query()->limit(4)->get();

        return view('pages.frontsite.landing-page.index', compact('specialists', 'doctors'));
    }
}
