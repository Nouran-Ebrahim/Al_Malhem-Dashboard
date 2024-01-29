<?php

namespace Modules\Volunteering\Http\Controllers\api;

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
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {

        $request_data = $request->all();
        $ralation = ['volunteeringTypes'];
        $request_data['auth_id'] = \auth('client')->id();
        $request_data['is_active'] = 1;
        $volunteering = $this->volunteeringService->all($request_data, $ralation );
        // dd($volunteering);

        return $volunteering;
    }



    public function store(Request $request)
    {
        // dd($request->all());
        // $request_data = $request->all();
        $AuthId = \auth('client')->id();
        // $request_data['client_id']= \auth('client')->id();
        $request->request->add(['client_id' => $AuthId]);
        // dd($request->all());
        $response = $this->volunteeringService->create($request);

        return $response;
    }


}
