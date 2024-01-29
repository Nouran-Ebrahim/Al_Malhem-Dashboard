<?php

namespace Modules\HumanService\Http\Controllers\api;

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
        $this->middleware('auth:client');
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['client', 'serviceType', 'images'];
        $request_data = $request->all();
        $request_data['is_active'] = 1;
        $service = $this->serviceService->all($request_data, $relation);

        return $service;
    }
    public function store(Request $request)
    {

        $request_data = $request->all();
        // dd($request_data);
        $request_data['client_id'] = \auth('client')->id();

        $response = $this->serviceService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return $response;
    }
}
