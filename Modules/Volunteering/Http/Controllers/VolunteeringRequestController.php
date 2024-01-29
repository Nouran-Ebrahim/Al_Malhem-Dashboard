<?php

namespace Modules\Volunteering\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Volunteering\Service\VolunteeringRequest\VolunteeringRequestService;
use Modules\Volunteering\ViewModel\VolunteeringViewModel;

class VolunteeringRequestController extends Controller
{
    private $volunteeringRequestService;

    public function __construct()
    {
        $this->volunteeringRequestService = new VolunteeringRequestService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-volunteering_request|Create-volunteering_request|Edit-volunteering_request|Delete-volunteering_request', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-volunteering_request', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-volunteering_request', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-volunteering_request', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['volunteeringTypes', 'images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();

        $viewModel = new VolunteeringViewModel();

        $volunteering_request = $this->volunteeringRequestService->all($request_data, $relation)['data'];
        // dd($volunteering_request );
        if ($request->ajax()) {
            return response()->json(['data' => $volunteering_request->items()]);
        }
        return view('volunteering::volunteeringRequest.index', [
            'volunteering_request' => $volunteering_request,
            'viewModel' => $viewModel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new VolunteeringViewModel();

        return view('volunteering::volunteeringRequest.create', compact('viewModel'));
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->volunteeringRequestService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/volunteeringRequest')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('volunteering_request ::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $volunteering_request = $this->volunteeringRequestService->find($id)['data'];
        $viewModel = new VolunteeringViewModel();

        $volunteeringtypesArray = $volunteering_request->volunteeringTypes()->pluck('volunteering_req_types.volunteering_type_id')->all();

        return view('volunteering::volunteeringRequest.edit',[
            'volunteeringtypesArray'=>$volunteeringtypesArray,
            'volunteering_request'=>$volunteering_request,
            'viewModel'=>$viewModel
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->volunteeringRequestService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteeringRequest')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['volunteeringTypes', 'images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->volunteeringRequestService->delete($request_data['id'], $relation);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->volunteeringRequestService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/volunteeringRequest')->with('updated', 'updated');
    }
    public function deleteVolunteeringRequestPhoto(request $request)
    {
        $this->volunteeringRequestService->deleteVolunteeringRequestPhoto($request->volunteering_request_photo_id);
        return back();
    }
}
