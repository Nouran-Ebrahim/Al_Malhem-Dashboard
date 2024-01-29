<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Service\NewsCategory\NewsCategoryService;

class NewsCategoriesController extends Controller
{
    private $newsCategoryService;

    public function __construct()
    {
        $this->newsCategoryService = new NewsCategoryService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-news_category|Create-news_category|Edit-news_category|Delete-news_category', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-news_category', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-news_category', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-news_category', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
       
        $newsCategories = $this->newsCategoryService->all($request_data)['data'];
        if ($request->ajax()) {
            return response()->json(['data' => $newsCategories->items()]);
        }
        return view('news::newsCategories.index',[
            'newsCategories' => $newsCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('news::newsCategories.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        $response = $this->newsCategoryService->create($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/newsCategory')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('news::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $newsCategory = $this->newsCategoryService->find($id)['data'];
        //dd($teacher_levels);
        return view('news::newsCategories.edit', compact('newsCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        $response = $this->newsCategoryService->update($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/newsCategory')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $request_data = $request->all();
        
        $response = $this->newsCategoryService->delete($request_data['id']);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
        
    }
    
    public function activate($id)
    {
        // dd($id);
        $response = $this->newsCategoryService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/newsCategory')->with('updated', 'updated');
    }
}
