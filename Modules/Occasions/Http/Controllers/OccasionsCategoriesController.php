<?php

namespace Modules\Occasions\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Occasions\Service\OccasionsCategory\OccasionsCategoryService;

class OccasionsCategoriesController extends Controller
{
    private $occasionsCategoryService;

    public function __construct()
    {
        $this->occasionsCategoryService = new OccasionsCategoryService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-occasions_category|Create-occasions_category|Edit-occasions_category|Delete-occasions_category', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-occasions_category', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-occasions_category', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-occasions_category', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();

        $occasionsCategories = $this->occasionsCategoryService->all($request_data)['data'];
        if ($request->ajax()) {
            return response()->json(['data' => $occasionsCategories->items()]);
        }
        return view('occasions::occasionsCategories.index',[
            'occasionsCategories'=> $occasionsCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('occasions::occasionsCategories.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        $response = $this->occasionsCategoryService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/occasionsCategory')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('occasions::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $occasionsCategory = $this->occasionsCategoryService->find($id)['data'];
        // dd($occasionsCategory);
        return view('occasions::occasionsCategories.edit', compact('occasionsCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();

        $response = $this->occasionsCategoryService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/occasionsCategory')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $request_data = $request->all();

        $response = $this->occasionsCategoryService->delete($request_data['id']);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);

    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->occasionsCategoryService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/occasionsCategory')->with('updated', 'updated');
    }
}