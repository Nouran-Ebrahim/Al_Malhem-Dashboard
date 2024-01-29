<?php

namespace Modules\Volunteering\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Volunteering\Service\VolunteeringType\VolunteeringTypesService;

class VolunteeringTypesController extends Controller
{
    private $volunteeringTypesService;

    public function __construct()
    {
        $this->volunteeringTypesService = new VolunteeringTypesService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-volunteering_type|Create-volunteering_type|Edit-volunteering_type|Delete-volunteering_type', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-volunteering_type', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-volunteering_type', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-volunteering_type', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $request_data = $request->all();

        $volunteeringTypes = $this->volunteeringTypesService->all($request_data)['data'];
        if ($request->ajax()) {
            return response()->json(['data' => $volunteeringTypes]);
        }
        return view('volunteering::volunteeringTypes.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('volunteering::volunteeringTypes.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        $response = $this->volunteeringTypesService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/volunteeringTypes')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('volunteering::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $volunteeringTypes = $this->volunteeringTypesService->find($id)['data'];
        //dd($teacher_levels);
        return view('volunteering::volunteeringTypes.edit', compact('volunteeringTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        $response = $this->volunteeringTypesService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteeringTypes')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $request_data = $request->all();

        $response = $this->volunteeringTypesService->delete($request_data['id']);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);

    }

    public function activate($id)
    {
        // dd($id);
        $response = $this->volunteeringTypesService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteeringTypes')->with('updated', 'updated');
    }
}