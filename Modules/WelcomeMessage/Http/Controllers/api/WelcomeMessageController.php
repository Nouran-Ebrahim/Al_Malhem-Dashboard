<?php

namespace Modules\WelcomeMessage\Http\Controllers\api;

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

    }
    public function index(Request $request)
    {
        // dd(1);
        $data['is_active'] = 1;
        $data['paginated'] = $request->paginated;
        $data['lastMessages'] = 1;

        $WelcomeMessage = $this->WelcomeMessageService->all($data);
        // dd($WelcomeMessage->items());


        return $WelcomeMessage;
    }


}
