<?php

namespace Modules\Occasions\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Occasions\Service\Occasions\OccasionsService;

class OccasionsController extends Controller
{

    private $occasionsService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->occasionsService = new OccasionsService();
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = 1;
        $relation = ['occasionsCategories', 'images'];
        return $this->occasionsService->all($data, $relation);
    }

}
