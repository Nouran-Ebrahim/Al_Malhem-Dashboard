<?php

namespace Modules\ScientificExcellence\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ScientificExcellence\Service\Party\PartyService;

class PartyController extends Controller
{
    private $partyService;

    public function __construct()
    {
        $this->partyService = new PartyService();
        $this->middleware('auth:client');
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['superiors','images'];
        $request_data = $request->all();
        $request_data['is_active'] = 1;

        $party  = $this->partyService->all($request_data, $relation);
        // dd($party );

        return  $party;
    }


}
