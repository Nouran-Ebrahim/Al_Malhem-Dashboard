<?php


namespace Modules\Meeting\Service\Meeting;


use Illuminate\Validation\Rule;


trait MeetingServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'lat'=>'required',
            'long'=>'required',
            'phone'=>'required',
            'client_id'=>'required',
            // 'news_category_id'=>'required|nullable'
            // 'image' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'phone' => 'required',
            'client_id' => 'required',
            // 'news_category_id'=>'required|nullable'
        ]);
    }
}
