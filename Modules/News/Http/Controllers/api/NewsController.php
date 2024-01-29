<?php

namespace Modules\News\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Service\News\NewsService;

class NewsController extends Controller
{

    private $newsService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->newsService = new NewsService();
        $this->middleware('auth:client')->except("index");
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = 1;
        $relation = ['newsCategories', 'images'];
        return $this->newsService->all($data, $relation);
    }

}
