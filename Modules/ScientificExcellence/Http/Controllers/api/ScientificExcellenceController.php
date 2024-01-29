<?php

namespace Modules\ScientificExcellence\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ScientificExcellence\Service\Superior\SuperiorService;
use Modules\ScientificExcellence\ViewModel\SuperiorViewModel;

class ScientificExcellenceController extends Controller
{
    private $superiorService;

    public function __construct()
    {
        $this->superiorService = new SuperiorService();
        $this->middleware('auth:client');
    }
 

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->superiorService->create($request_data);
       
        return  $response;
    }


}
