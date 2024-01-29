<?php

namespace Modules\HumanService\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanService\Service\ServiceType\ServiceTypeService;

class ServiceTypeController extends Controller
{
    private $serviceTypeService;

    public function __construct()
    {
        $this->serviceTypeService = new ServiceTypeService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-service_type|Create-service_type|Edit-service_type|Delete-service_type', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-service_type', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-service_type', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-service_type', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();

        $serviceType = $this->serviceTypeService->all($request_data)['data'];
        if ($request->ajax()) {
            return response()->json(['data' => $serviceType->items()]);
        }
        return view('humanservice::serviceType.index',[
            'serviceType'=>$serviceType
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('humanservice::serviceType.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        $response = $this->serviceTypeService->create($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/serviceType')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('news::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $serviceType = $this->serviceTypeService->find($id)['data'];
        //dd($teacher_levels);
        return view('humanservice::serviceType.edit', compact('serviceType'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        $response = $this->serviceTypeService->update($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/serviceType')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $request_data = $request->all();

        $response = $this->serviceTypeService->delete($request_data['id']);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }

    public function activate($id)
    {
        // dd($id);
        $response = $this->serviceTypeService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/serviceType')->with('updated', 'updated');
    }
}
