<?php

namespace Modules\Common\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactUs;
use Modules\Common\Http\Requests\ContactUsRequest;
use Spatie\Activitylog\Models\Activity;

class CommonController extends Controller
{
    public function setting()
    {
        $settings = Setting::all();
        return view('common::setting.index', ['settings' => $settings]);
    }

    public function savesetting(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $datum) {
            if ($key == 'logo' && isset($datum)) {
                $old_image = Setting::where('key', 'logo')->first()['value'];
                File::delete(public_path('uploads/setting/' . $old_image));
                $image = $request->file('logo');
                $imageName = $this->upload($image, 'setting');
                $datum = $imageName;
            }
            Setting::where('key', $key)->update(['value' => $datum]);
        }
        return back()->with('updated', 'updated');
    }

    public function logs()
    {
        $logs = Activity::with('causer')->latest()->paginate(50);
        return view('common::logs.index', compact('logs'));
    }
}
