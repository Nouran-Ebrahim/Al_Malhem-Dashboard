<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Admin\DTO\AdminDto;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Service\AdminService;
use Modules\Admin\Service\RoleService;
use Modules\Admin\Validation\AdminValidation;
use Modules\Admin\ViewModel\AdminViewModel;
use Modules\Common\Helper\UploaderHelper;
use Modules\Order\Entities\Order;
use Modules\Client\Service\ClientService;
use Modules\ScientificExcellence\Service\Party\PartyService;
use Modules\Meeting\Service\Meeting\MeetingService;
use Modules\Occasions\Service\Occasions\OccasionsService;
use Modules\News\Service\News\NewsService;
use Modules\ScientificExcellence\Service\Superior\SuperiorService;

class AdminController extends Controller
{
    use UploaderHelper, AdminValidation;
    private $adminService;
    private $clientService;
    private $partyService;
    private $meetingService;
    private $occasionsService;
    private $newsService;
    private $superiorService;

    public function __construct(AdminService $adminService, ClientService $clientService)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->adminService = $adminService;
        $this->clientService = $clientService;
        $this->partyService = new PartyService();
        $this->meetingService = new MeetingService();
        $this->occasionsService = new OccasionsService();
        $this->newsService = new NewsService();
        $this->superiorService = new SuperiorService();

        $this->middleware('permission:Index-admin|Create-admin|Edit-admin|Delete-admin', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-admin', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-admin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function dashboard()
    {
        $activeClients = $this->clientService->active();
        $clients = $this->clientService->findAll();
        $notActiveClients = $clients->count() - $activeClients->count();

        $partyData['lastDaysCount'] = 30;
        $allParty  = $this->partyService->all($partyData)['data']->count();
        $partyData['is_active'] = 1;
        $activeParty  = $this->partyService->all($partyData)['data']->count();

        $notActiveParty = $allParty - $activeParty;
        if ($allParty === 0) {
            $activePartyPersentage = 0;
            $notActivePartyPersentage = 0;
        } else {
            $activePartyPersentage = ($activeParty / $allParty) * 100;
            $notActivePartyPersentage
                = ($notActiveParty / $allParty) * 100;
        }



        $occasionsData['lastDaysCount'] = 30;
        $occasions  = $this->occasionsService->all($occasionsData)['data']->count();
        $occasionsData['is_active'] = 1;
        $occasionsActive  = $this->occasionsService->all($occasionsData)['data']->count();
        if ($occasions === 0) {
            $occasionsActivePresentage = 0;
        } else {
            $occasionsActivePresentage = round(($occasionsActive / $occasions) * 100);
        }

        // dd($occasionsActivePresentage);
        $data['lastDaysCount'] = 30;
        $meeting = $this->meetingService->all($data)['data']->count();

        $data['is_active'] = 1;
        $Activemeeting = $this->meetingService->all($data)['data']->count();

        $NotActivemeeting = $meeting - $Activemeeting;

        if ($meeting === 0) {
            $activemeetingPersentage = 0;
            $notActivemeetingPersentage = 0;
        } else {
            $activemeetingPersentage = ($Activemeeting / $meeting) * 100;
            $notActivemeetingPersentage
                = ($NotActivemeeting / $meeting) * 100;
        }
        $newsData['lastDaysCount'] = 30;
        $news = $this->newsService->all($newsData)['data']->count();
        $newsData['is_active'] = 1;
        $Activenews = $this->newsService->all($newsData)['data']->count();
        $NotActiveenews = $news - $Activenews;

        $superiorActive  = $this->superiorService->all($data)['data']->count();

        return view('admin::index', [
            'activeClients' => $activeClients,
            'notActiveClients' => $notActiveClients,
            'activeParty' => $activeParty,
            'notActiveParty' => $notActiveParty,
            'Activemeeting' => $Activemeeting,
            "NotActivemeeting" => $NotActivemeeting,
            'occasions' => $occasions,
            'Activenews' => $Activenews,
            'NotActiveenews' => $NotActiveenews,
            'occasionsActivePresentage' => $occasionsActivePresentage,
            'superiorActive' => $superiorActive,
            'activePartyPersentage' => $activePartyPersentage,
            'notActivePartyPersentage' => $notActivePartyPersentage,
            'activemeetingPersentage'=> $activemeetingPersentage,
            'notActivemeetingPersentage'=> $notActivemeetingPersentage,
            'lastDaysCount'=> $data['lastDaysCount'],
        ]);
    }


    public function index(Request $request)
    {
        $admins = $this->adminService->findAll();
        $roles = (new RoleService())->findAll(['id', 'name']);
        if ($request->ajax()) {
            return response()->json(['data' => $admins]);
        }
        return view('admin::admins.index', ['admins' => $admins, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = (new RoleService())->findAll(['id', 'name']);
        $viewModel = new AdminViewModel();
        return view('admin::admins.create', compact('roles', 'viewModel'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = (new AdminDto($request))->dataFromRequest();
        $validation = $this->validateStore($data);
        if ($validation->fails()) return redirect()->back()->withInput()->withErrors($validation);
        $admin = $this->adminService->save($data);
        return redirect('admin/admins')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $admin = $this->adminService->findById($id);
        $roles = (new RoleService())->findAll(['id', 'name']);
        $viewModel = new AdminViewModel();
        $userRole = $admin->roles->pluck('name', 'name')->all();
        return view('admin::admins.edit', compact('admin', 'roles', 'userRole', 'viewModel'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data = (new AdminDto($request))->dataFromRequest();
        $validation = $this->validateUpdate($data, $id);
        if ($validation->fails()) return redirect()->back()->withInput()->withErrors($validation);
        $admin = $this->adminService->update($id, $data);
        return redirect('admin/admins')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        $this->adminService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }

    public function activate($id)
    {
        $this->adminService->activate($id);
        return redirect('admin/admins')->with('updated', 'updated');
    }
}
