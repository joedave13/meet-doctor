<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\Consultation\StoreConsultationRequest;
use App\Http\Requests\Backsite\Consultation\UpdateConsultationRequest;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('consultation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $consultations = Consultation::query()->orderBy('name');

            return datatables()
                ->eloquent($consultations)
                ->addColumn('action', 'pages.backsite.consultation.table-action')
                ->editColumn('level', function ($item) {
                    switch ($item->level) {
                        case 1:
                            return '<span class="bg-green-200 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Low</span>';
                            break;
                        case 2:
                            return '<span class="bg-yellow-200 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Medium</span>';
                            break;
                        case 3:
                            return '<span class="bg-red-500 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">High</span>';
                            break;
                        default:
                            return '<span class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Unknown</span>';
                            break;
                    }
                })
                ->rawColumns(['action', 'level'])
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
        abort_if(Gate::denies('consultation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('consultation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('consultation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('consultation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('consultation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $consultation->delete();

        toast('Consultation deleted successfully!', 'success');
        return redirect()->route('backsite.consultation.index');
    }
}
