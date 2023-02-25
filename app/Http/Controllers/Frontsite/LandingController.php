<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('pages.frontsite.landing-page.index');
    }
}
