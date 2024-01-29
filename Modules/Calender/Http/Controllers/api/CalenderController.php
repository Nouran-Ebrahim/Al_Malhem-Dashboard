<?php

namespace Modules\Calender\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Calender\Service\Calender\CalenderService;

class CalenderController extends Controller
{
    private $calenderService;

    public function __construct()
    {
        $this->calenderService = new CalenderService();
        $this->middleware('auth:client');

    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['images'];
        $request_data = $request->all();
        $request_data['is_active'] = 1;
        $calender = $this->calenderService->all($request_data, $relation)['data'];
        // dd($calender);
        if ($request->ajax()) {
            return response()->json(['data' => $calender]);
        }
        return $calender;
    }

    public function dates(Request $request)
    {
        return $this->calenderService->dates();

    }


}
