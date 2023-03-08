<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\User\StoreUserRequest;
use App\Http\Requests\Backsite\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $users = User::with(['user_detail', 'user_detail.user_type', 'roles'])->orderBy('name', 'asc');

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
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

            toast('User created successfully!', 'success');

            return redirect()->route('backsite.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.backsite.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userTypes = UserType::all();
        $roles = Role::all();

        return view('pages.backsite.user.edit', compact('user', 'userTypes', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        try {
            $userData = $request->only(['name', 'email']);

            if ($request->has('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $userDetailData = $request->only(['user_type_id', 'age', 'contact', 'address']);

            if ($request->has('photo')) {
                if ($user->user_detail->photo && Storage::disk('public')->exists($user->user_detail->photo)) {
                    Storage::disk('public')->delete($user->user_detail->photo);
                }

                $userDetailData['photo'] = $request->file('photo')->store('user/photo', 'public');
            }

            $user->user_detail->update($userDetailData);

            $user->roles()->sync($request->role_id);

            DB::commit();

            toast('User updated successfully!', 'success');

            return redirect()->route('backsite.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        toast('User deleted successfully!', 'success');

        return redirect()->route('backsite.user.index');
    }
}
