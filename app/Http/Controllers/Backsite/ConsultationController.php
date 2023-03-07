<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\Consultation\StoreConsultationRequest;
use App\Http\Requests\Backsite\Consultation\UpdateConsultationRequest;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $consultations = Consultation::query()->orderBy('name');

            return datatables()
                ->eloquent($consultations)
                ->addColumn('action', 'pages.backsite.consultation.table-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.backsite.consultation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backsite.consultation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConsultationRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);

            Consultation::query()->create($data);

            DB::commit();

            toast('Consultation created successfully!', 'success');
            return redirect()->route('backsite.consultation.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        return view('pages.backsite.consultation.edit', compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConsultationRequest $request, Consultation $consultation)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_method', '_token']);

            $consultation->update($data);

            DB::commit();

            toast('Consultation updated successfully!', 'success');
            return redirect()->route('backsite.consultation.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast($th->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        toast('Consultation deleted successfully!', 'success');
        return redirect()->route('backsite.consultation.index');
    }
}
