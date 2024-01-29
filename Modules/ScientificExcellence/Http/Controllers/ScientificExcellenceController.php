<?php

namespace Modules\ScientificExcellence\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ScientificExcellence\Service\Superior\SuperiorService;
use Modules\ScientificExcellence\ViewModel\SuperiorViewModel;

class ScientificExcellenceController extends Controller
{
    private $superiorService;

    public function __construct()
    {
        $this->superiorService = new SuperiorService();
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->middleware('permission:Index-superior|Create-superior|Edit-superior|Delete-superior', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-superior', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-superior', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-superior', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd(1);
        $relation = ['party'];
        $request->request->add(['paginated' => 50]);

        $request_data = $request->all();

        $viewModel = new SuperiorViewModel();


        $superior  = $this->superiorService->all($request_data, $relation)['data'];
        $party_ids= $superior->pluck('party_id', 'party_id')->toArray();
        // if(in_array(3,$party_ids)){
        //     dd(1);
        // }
        if ($request->ajax()) {
            return response()->json(['data' => $superior->items()]);
        }
        return view('scientificexcellence::superior.index',[
            'viewModel'=> $viewModel,
            'party_ids'=> $party_ids,
            'superior'=> $superior
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new SuperiorViewModel();

        return view('scientificexcellence::superior.create',[
            'viewModel' => $viewModel
        ]);
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->superiorService->create($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('/admin/superior')->with('created', 'created');
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('superior ::show');
    }

    public function edit(Request $request, $id)
    {
        $request_data = $request->all();
        $superior  = $this->superiorService->find($id)['data'];
        $viewModel = new SuperiorViewModel();

        return view('scientificexcellence::superior.edit', compact('superior', 'viewModel'));
    }

    public function update(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request_data = $request->all();
        // dd($request_data);
        $response = $this->superiorService->update($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/superior')->with('updated', 'updated');
    }
    public function addParty(Request $request)
    {
        
        $request_data = $request->all();
    
        $response = $this->superiorService->addParty($request_data);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/superior')->with('addParty', 'addParty');
    }
    public function destroy(Request $request)
    {
        $relation = ['party'];

        $request_data = $request->all();
        // dd($request_data);
        $response = $this->superiorService->delete($request_data['id'], $relation);
        if (!$response['status']) return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return response()->json(['data' => 'success'], 200);
    }
    public function activate($id)
    {
        // dd($id);
        $response = $this->superiorService->activate($id);
        if (!$response['status'])
            return redirect()->back()->withInput()->withErrors($response['data']['validation_errors']);
        return redirect('admin/superior')->with('updated', 'updated');
    }
    // public function deleteSuperiorPhoto(request $request)
    // {
    //     $this->superiorService->deleteSuperiorPhotos($request->superior_photo_id);
    //     return back();
    // }

}
