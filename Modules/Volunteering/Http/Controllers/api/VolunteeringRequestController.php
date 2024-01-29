<?php

namespace Modules\Volunteering\Http\Controllers\api;

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
        $this->middleware('auth:client');

    }

    public function index(Request $request)
    {
        // dd(1);
        $relation = ['volunteeringTypes', 'images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        $request_data['is_active'] = 1;
        // if ($request_data['volunteering_request_id'] ?? null) {
        $request_data['client_id'] = \auth('client')->id();
        $volunteering_request = $this->volunteeringRequestService->all($request_data, $relation);

        // } else {
        //     $volunteering_request = $this->volunteeringRequestService->all($request_data, $relation);

        // }
        // dd($volunteering_request );

        return $volunteering_request;
    }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     $viewModel = new VolunteeringViewModel();

    //     return view('volunteering::volunteeringRequest.create', compact('viewModel'));
    // }

    public function join(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $request_data['client_id'] = \auth('client')->id();

        $response = $this->volunteeringRequestService->join($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return $response;
    }
    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('volunteering_request ::show');
    // }

    // public function edit(Request $request, $id)
    // {
    //     $request_data = $request->all();
    //     $volunteering_request = $this->volunteeringRequestService->find($id)['data'];
    //     $viewModel = new VolunteeringViewModel();

    //     $volunteeringtypesArray = $volunteering_request->volunteeringTypes()->pluck('volunteering_req_types.volunteering_type_id')->all();

    //     return view('volunteering::volunteeringRequest.edit',[
    //         'volunteeringtypesArray'=>$volunteeringtypesArray,
    //         'volunteering_request'=>$volunteering_request,
    //         'viewModel'=>$viewModel
    //     ]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->request->add(['id' => $id]);
    //     $request_data = $request->all();
    //     // dd($request_data);
    //     $response = $this->volunteeringRequestService->update($request_data);
    //     if (!$response['status'])
    //         return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
    //     return redirect('admin/volunteering_request')->with('updated', 'updated');
    // }

    // public function destroy(Request $request)
    // {
    //     $relation = ['volunteeringTypes', 'images'];

    //     $request_data = $request->all();
    //     // dd($request_data);
    //     $response = $this->volunteeringRequestService->delete($request_data['id'], $relation);
    //     if (!$response['status'])
    //         return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
    //     return response()->json(['data' => 'success'], 200);
    // }
    // public function activate($id)
    // {
    //     // dd($id);
    //     $response = $this->volunteeringRequestService->activate($id);
    //     if (!$response['status'])
    //         return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
    //     return redirect('admin/volunteering_request')->with('updated', 'updated');
    // }
    // public function deleteVolunteeringRequestPhoto(request $request)
    // {
    //     $this->volunteeringRequestService->deleteVolunteeringRequestPhoto($request->volunteering_request_photo_id);
    //     return back();
    // }
}
