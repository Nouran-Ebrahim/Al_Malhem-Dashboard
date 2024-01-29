<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Service\News\NewsService;
use Modules\News\ViewModel\NewsCategoriesViewModel;

class NewsController extends Controller
{
    private $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-news|Create-news|Edit-news|Delete-news', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-news', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-news', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-news', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['newsCategories', 'images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        $viewModel = new NewsCategoriesViewModel();

        $news = $this->newsService->all($request_data, $relation)['data'];
        // dd($news);
        if ($request->ajax()) {
            return response()->json(['data' => $news->items()]);
        }
        return view('news::news.index', [
            'viewModel' => $viewModel,
            'news' => $news

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new NewsCategoriesViewModel();
        return view('news::news.create', [
            'viewModel' => $viewModel
        ]);
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->newsService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/news')->with('created', 'created');
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
        $news = $this->newsService->find($id)['data'];
        $viewModel = new NewsCategoriesViewModel();

        return view('news::news.edit', compact('news', 'viewModel'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->newsService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/news')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['newsCategories', 'images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->newsService->delete($request_data['id'], $relation);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->newsService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/news')->with('updated', 'updated');
    }
    public function deleteNewsPhoto(request $request)
    {
        $this->newsService->deleteNewsPhotos($request->news_photo_id);
        return back();
    }
}