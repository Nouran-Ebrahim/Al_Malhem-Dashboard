<?php

namespace Modules\Common\Http\Controllers\api;

use Illuminate\Routing\Controller;
use Modules\Common\Entities\Setting;
use Modules\Common\Service\CommonService;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Mail\contactUs;
use Modules\Common\Http\Requests\ContactUsRequest;

class CommonController extends Controller
{

    private $CommonService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    public function terms()
    {
        return return_msg(true, 'Terms Data  ', getSetting('terms'));
    }

    public function about()
    {
        return return_msg(true, 'About Data  ', getSetting('about'));
    }

    public function contactUs(ContactUsRequest $request)
    {

        Mail::to(getSetting('email'))->send(new contactUs($request->email, $request->message, $request->phone));

        return return_msg(true, 'Message Sent successfully');
    }

    public function contactData()
    {

        $data = Setting::whereIn('key',['whatsapp','twitter','snapchat','instagram','youtube'])->select('key','value')->get();
        return return_msg(true, 'Social Media Data', $data);
    }
}
