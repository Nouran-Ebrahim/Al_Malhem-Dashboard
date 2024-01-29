<?php

namespace Modules\Volunteering\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Volunteering\Service\Volunteering\VolunteeringService;
use Modules\Volunteering\ViewModel\VolunteeringViewModel;

class VolunteeringController extends Controller
{
    private $volunteeringService;

    public function __construct()
    {
        $this->volunteeringService = new VolunteeringService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-volunteering|Create-volunteering|Edit-volunteering|Delete-volunteering', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-volunteering', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-volunteering', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-volunteering', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request->request->add(['paginated' => 50]);
        // dd(1);
        $request_data = $request->all();
        $ralation = ['volunteeringTypes'];

        $volunteering = $this->volunteeringService->all($request_data, $ralation)['data'];
        //  dd($volunteering);
        $viewModel = new VolunteeringViewModel();

        if ($request->ajax()) {
            return response()->json(['data' => $volunteering->items()]);
        }
        return view('volunteering::volunteering.index', compact('volunteering', 'viewModel'));
    }


    public function create()
    {
        $viewModel = new VolunteeringViewModel();
        
        // dd($clientWithNoVolunteering);
        return view('volunteering::volunteering.create', compact('viewModel'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $response = $this->volunteeringService->create($request);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/volunteering')->with('created', 'created');
    }

    public function edit(Request $request, $id)
    {
        $volunteering = $this->volunteeringService->find($id)['data'];
        $viewModel = new VolunteeringViewModel();
        $volunteeringtypesArray = $volunteering->volunteeringTypes()->pluck('volunteering_types_volunteerings.volunteering_type_id')->all();
        return view('volunteering::volunteering.edit', compact('volunteering', 'viewModel', 'volunteeringtypesArray'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        // dd($request->all());
        $response = $this->volunteeringService->update($request);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteering')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $request_data = $request->all();
        $response = $this->volunteeringService->delete($request_data['id']);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function  getClientData($id)
    {
        // dd($id);
        $clientData = Client::where('id', $id)->first();
        return response()->json($clientData);
    }
    public function activate($id)
    {
        $response = $this->volunteeringService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteering')->with('updated', 'updated');
    }
}
