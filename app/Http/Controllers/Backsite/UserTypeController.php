<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
