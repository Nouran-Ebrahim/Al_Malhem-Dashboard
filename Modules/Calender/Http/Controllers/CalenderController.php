<?php

namespace Modules\Calender\Http\Controllers;

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
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-calender|Create-calender|Edit-calender|Delete-calender', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-calender', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-calender', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-calender', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['images'];
        // $request->request->add(['paginated'=>4]);
        $request->request->add(['paginated' => 50]);
        $request_data = $request->all();
        // $request_data['paginated'] = 2;

        $calender = $this->calenderService->all($request_data, $relation)['data'];
        // dd($calender);
        if ($request->ajax()) {
            return response()->json(['data' => $calender->items()]);
        }
        return view('calender::calender.index',[
            'calender'=>$calender
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('calender::calender.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->calenderService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/calender')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('calender::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $calender = $this->calenderService->find($id)['data'];


        return view('calender::calender.edit', compact('calender'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->calenderService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/calender')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->calenderService->delete($request_data['id'], $relation);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->calenderService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/calender')->with('updated', 'updated');
    }
    public function deleteCalenderPhoto(request $request)
    {
        $this->calenderService->deleteCalenderPhotos($request->calender_photo_id);
        return back();
    }
}
