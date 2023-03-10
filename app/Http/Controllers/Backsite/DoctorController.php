<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\Doctor\StoreDoctorRequest;
use App\Http\Requests\Backsite\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('doctor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $doctors = Doctor::with(['specialist'])->orderBy('name');

            return datatables()
                ->eloquent($doctors)
                ->addColumn('action', 'pages.backsite.doctor.table-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.backsite.doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('doctor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialists = Specialist::all();

        return view('pages.backsite.doctor.create', compact('specialists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {
        abort_if(Gate::denies('doctor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        try {
            $data = $request->except(['_token', 'photo']);

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('doctor/photo', 'public');
            }

            Doctor::query()->create($data);

            DB::commit();

            toast('Doctor created successfully!', 'success');
            return redirect()->route('backsite.doctor.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.backsite.doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialists = Specialist::all();

        return view('pages.backsite.doctor.edit', compact('doctor', 'specialists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        try {
            $data = $request->except(['_token', '_method', 'photo']);

            if ($request->hasFile('photo')) {
                if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
                    Storage::disk('public')->delete($doctor->photo);
                }

                $data['photo'] = $request->file('photo')->store('doctor/photo', 'public');
            }

            $doctor->update($data);

            DB::commit();

            toast('Doctor updated successfully!', 'success');
            return redirect()->route('backsite.doctor.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->delete();

        toast('Doctor deleted successfully!', 'success');
        return redirect()->route('backsite.doctor.index');
    }
}
