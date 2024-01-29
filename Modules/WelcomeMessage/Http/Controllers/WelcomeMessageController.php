<?php

namespace Modules\WelcomeMessage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WelcomeMessage\Service\WelcomeMessage\WelcomeMessageService;

class WelcomeMessageController extends Controller
{
    private $WelcomeMessageService;

    public function __construct()
    {
        $this->WelcomeMessageService = new WelcomeMessageService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-welcome_message|Create-welcome_message|Edit-welcome_message|Delete-welcome_message', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-welcome_message', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-welcome_message', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-welcome_message', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        // $relations = ['category','qestions'];


        $WelcomeMessage = $this->WelcomeMessageService->all($request_data)['data'];
        // dd($WelcomeMessage->items());
        if ($request->ajax()) {
            return response()->json(['data' => $WelcomeMessage->items()]);
        }

        return view('welcomemessage::welcomemessage.index', [

            'welcomemessage' => $WelcomeMessage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('welcomemessage::welcomemessage.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->WelcomeMessageService->create($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/welcomeMessages')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('exercise::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // dd($id);

        $welcomemessage = $this->WelcomeMessageService->find($id)['data'];
        return view('welcomemessage::welcomemessage.edit', [
            'welcomemessage' => $welcomemessage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->WelcomeMessageService->update($request_data);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/welcomeMessages')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->WelcomeMessageService->delete($request_data['id']);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->WelcomeMessageService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/welcomeMessages')->with('updated', 'updated');
    }
}
