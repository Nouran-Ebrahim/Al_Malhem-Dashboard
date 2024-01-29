<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Meeting\Entities\Workinghour;
use Modules\Meeting\Service\Meeting\MeetingService;
use Modules\Meeting\ViewModel\ClientViewModel;

class MeetingController extends Controller
{
    private $meetingService;

    public function __construct()
    {
        $this->meetingService = new MeetingService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-meeting|Create-meeting|Edit-meeting|Delete-meeting', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-meeting', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-meeting', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-meeting', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['client', 'images', 'workingHours'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        // $request_data['paginated']=2;
        $viewModel = new ClientViewModel();
        $meeting = $this->meetingService->all($request_data, $relation)['data'];

        if ($request->ajax()) {
            return response()->json(['data' => $meeting->items()]);
        }
        return view('meeting::meeting.index', [
            'viewModel' => $viewModel,
            'meeting'=> $meeting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // dd(1);
        $viewModel = new ClientViewModel();
        return view('meeting::meeting.create', [
            'viewModel' => $viewModel
        ]);
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->meetingService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/meeting')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('meeting::show');
    }

    public function edit(Request $request, $id)
    {
        // dd($id);
        $relation = ['client', 'images', 'workingHours'];
        $request_data = $request->all();
        $meeting = $this->meetingService->find($id, $relation)['data'];
        // $days = $meeting->workingHours->pluck('day_name', 'day_name')->toArray();
        // dd($meeting->workingHours);

        $viewModel = new ClientViewModel();

        return view('meeting::meeting.edit', compact('meeting', 'viewModel'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->meetingService->update($request_data);

        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/meeting')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['client', 'images', 'workingHours'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->meetingService->delete($request_data['id'], $relation);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->meetingService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/meeting')->with('updated', 'updated');
    }
    public function deleteMeetingsPhotos(request $request)
    {
        // dd($request->all());
        $this->meetingService->deleteMeetingsPhotos($request->meeting_photo_id);
        return back();
    }
}
