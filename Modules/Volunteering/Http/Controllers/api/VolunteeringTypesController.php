<?php

namespace Modules\Volunteering\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Volunteering\Service\VolunteeringType\VolunteeringTypesService;

class VolunteeringTypesController extends Controller
{

    private $VolunteeringTypesService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->VolunteeringTypesService = new VolunteeringTypesService();
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = 1;
        return $this->VolunteeringTypesService->all($data);
    }

}
