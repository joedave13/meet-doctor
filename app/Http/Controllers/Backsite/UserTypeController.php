<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $userTypes = UserType::query();

            return datatables()
                ->eloquent($userTypes)
                ->addIndexColumn()
                ->make();
        }

        return view('pages.backsite.user-type.index');
    }
}
