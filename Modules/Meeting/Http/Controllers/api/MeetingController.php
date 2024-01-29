<?php

namespace Modules\Meeting\Http\Controllers\api;

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
        $this->middleware('auth:client');
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['client', 'images', 'workingHours'];
        $request_data = $request->all();

        if ($request_data['client_id'] ?? null) {
            $meeting = $this->meetingService->all($request_data, $relation);
        } else {
            $request_data['is_active'] = 1;
            $meeting = $this->meetingService->all($request_data, $relation);
        }


        return $meeting;
    }

    /**
     * Show the form for creating a new resource.
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd(1);
        $request_data = $request->all();
        $request_data['client_id'] = \auth('client')->id();
        // dd($request_data);
        $responseData = $this->meetingService->create($request_data);

        return  $responseData;
    }


    public function update(Request $request)
    {
        // dd($id);
        // $request->request->add(['id' => $id]);
        $request_data = $request->all();
        $request_data['client_id'] = \auth('client')->id();
        //  dd($request_data);
        // $request_data['is_active'] = 1;
        $responseData = $this->meetingService->update($request_data);
        if (!$responseData['status'])
            return redirect()->back()->withInput()->withErrors($responseData['data']['validation_errors']);
        return response()->json(['status' => 'updated']);
    }


    public function activate(request $request)
    {
        // dd($request->id);
        $responseData = $this->meetingService->activate($request->id);

        return $responseData;
    }
    public function deleteMeetingsPhotos(request $request)
    {
        // dd($request->all());
        $this->meetingService->deleteMeetingsPhotos($request->meeting_photo_id);
        return response()->json(['status' => 'photo deleted']);
    }
}
