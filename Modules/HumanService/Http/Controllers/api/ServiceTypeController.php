<?php

namespace Modules\HumanService\Http\Controllers\api;

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
        $this->middleware('auth:client');
    }
    public function index(Request $request)
    {
        // dd(1);
        $request_data = $request->all();
        $request_data['is_active'] = 1;
        $serviceType = $this->serviceTypeService->all($request_data);
        if ($request->ajax()) {
            return response()->json(['data' => $serviceType]);
        }
        return $serviceType;
    }


}
