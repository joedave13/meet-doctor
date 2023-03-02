<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\User\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::with(['user_detail', 'user_detail.user_type', 'roles']);

            return datatables()
                ->eloquent($users)
                ->addColumn('action', 'pages.backsite.user.table-action')
                ->editColumn('roles', function ($item) {
                    return implode(', ', $item->roles->pluck('name')->toArray());
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.backsite.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userTypes = UserType::all();
        $roles = Role::all();

        return view('pages.backsite.user.create', compact('userTypes', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $userData = $request->only(['name', 'email', 'password']);
            $userData['password'] = Hash::make($request->password);

            $user = User::query()->create($userData);

            $userDetailData = $request->only(['user_type_id', 'age', 'contact', 'address']);
            $userDetailData['user_id'] = $user->id;
            $userDetailData['age'] = $request->age ?? 0;

            if ($request->hasFile('photo')) {
                $userDetailData['photo'] = $request->file('photo')->store('user/photo', 'public');
            }

            UserDetail::query()->create($userDetailData);

            $user->roles()->sync($request->role_id);

            DB::commit();

            return redirect()->route('backsite.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
