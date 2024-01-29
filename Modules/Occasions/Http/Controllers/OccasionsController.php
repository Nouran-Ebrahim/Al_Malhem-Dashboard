<?php

namespace Modules\Occasions\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Occasions\Service\Occasions\OccasionsService;
use Modules\Occasions\ViewModel\OccasionsCategoriesViewModel;

class OccasionsController extends Controller
{
    private $occasionsService;

    public function __construct()
    {
        $this->occasionsService = new OccasionsService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-occasions|Create-occasions|Edit-occasions|Delete-occasions', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-occasions', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-occasions', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-occasions', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['occasionsCategories', 'images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        $viewModel = new OccasionsCategoriesViewModel();

        $occasions  = $this->occasionsService->all($request_data, $relation)['data'];
        // dd($occasions );
        if ($request->ajax()) {
            return response()->json(['data' => $occasions->items() ]);
        }
        return view('occasions::occasions.index', [
            'viewModel' => $viewModel,
            'occasions'=> $occasions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new OccasionsCategoriesViewModel();
        return view('occasions::occasions.create', [
            'viewModel' => $viewModel
        ]);
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->occasionsService->create($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/occasions')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('occasions ::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $occasions  = $this->occasionsService->find($id)['data'];
        $viewModel = new OccasionsCategoriesViewModel();

        return view('occasions::occasions.edit', compact('occasions', 'viewModel'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->occasionsService->update($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/occasions')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['occasionsCategories', 'images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->occasionsService->delete($request_data['id'], $relation);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->occasionsService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/occasions')->with('updated', 'updated');
    }
    public function deleteOccasionsPhoto(request $request)
    {
        $this->occasionsService->deleteOccasionsPhotos($request->occasions_photo_id);
        return back();
    }

}
