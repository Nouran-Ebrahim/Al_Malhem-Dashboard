<?php

namespace Modules\ScientificExcellence\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ScientificExcellence\Service\Party\PartyService;

class PartyController extends Controller
{
    private $partyService;

    public function __construct()
    {
        $this->partyService = new PartyService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-party|Create-party|Edit-party|Delete-party', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-party', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-party', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-party', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['superiors','images'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();
        

        $party  = $this->partyService->all($request_data, $relation)['data'];
        // dd($party );
        if ($request->ajax()) {
            return response()->json(['data' => $party->items() ]);
        }
        return view('scientificexcellence::party.index',[
            'party' => $party
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
  
        return view('scientificexcellence::party.create');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->partyService->create($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/party')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('party ::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $party  = $this->partyService->find($id)['data'];


        return view('scientificexcellence::party.edit', compact('party'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->partyService->update($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/party')->with('updated', 'updated');
    }

    public function destroy(Request $request)
    {
        $relation = ['superiors', 'images'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->partyService->delete($request_data['id'], $relation);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->partyService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/party')->with('updated', 'updated');
    }
    public function deletePartyPhoto(request $request)
    {
        $this->partyService->deletePartyPhotos($request->party_photo_id);
        return back();
    }

}
