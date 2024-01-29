<?php

namespace Modules\Occasions\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Occasions\Service\OccasionsCategory\OccasionsCategoryService;

class OccasionsCategoriesController extends Controller
{

    private $occasionsCategoryService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->occasionsCategoryService = new OccasionsCategoryService();
       $this->middleware('auth:client');
    }

    public function index(Request $request){
        $data = $request->all();
        $data['is_active'] = 1;
        return $this->occasionsCategoryService->all($data);
    }

}
