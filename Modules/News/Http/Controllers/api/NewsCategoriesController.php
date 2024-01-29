<?php

namespace Modules\News\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Service\NewsCategory\NewsCategoryService;

class NewsCategoriesController extends Controller
{

    private $newsCategoryService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->newsCategoryService = new NewsCategoryService();
       $this->middleware('auth:client')->except("index");
    }

    public function index(Request $request){
        $data = $request->all();
        $data['is_active'] = 1;
        return $this->newsCategoryService->all($data);
    }

}
