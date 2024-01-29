<?php

namespace Modules\HumanService\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanService\Service\Service\ServiceService;
use Modules\HumanService\ViewModel\ServiceViewModel;

class HumanServiceController extends Controller
{
    private $serviceService;

    public function __construct()
    {
        $this->serviceService = new ServiceService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-service|Create-service|Edit-service|Delete-service', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-service', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-service', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-service', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['serviceType', 'images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        $viewModel = new ServiceViewModel();

        $service = $this->serviceService->all($request_data, $relation)['data'];
        // dd($service);
        if ($request->ajax()) {
            return response()->json(['data' => $service->items()]);
        }
        return view('humanservice::service.index', [
            'viewModel' => $viewModel,
            'service'=>$service,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new ServiceViewModel();
        return view('humanservice::service.create', [
            'viewModel' => $viewModel
        ]);
    }

    public function store(Request $request)
    {
        
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->serviceService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/service')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $service = $this->serviceService->find($id)['data'];
        $viewModel = new ServiceViewModel();

        return view('humanservice::service.edit', compact('service', 'viewModel'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->serviceService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/service')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['servicetype', 'images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->serviceService->delete($request_data['id'], $relation);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->serviceService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/service')->with('updated', 'updated');
    }
    public function deleteServicePhoto(request $request)
    {
        $this->serviceService->deleteServicePhoto($request->service_photo_id);
        return back();
    }
}
