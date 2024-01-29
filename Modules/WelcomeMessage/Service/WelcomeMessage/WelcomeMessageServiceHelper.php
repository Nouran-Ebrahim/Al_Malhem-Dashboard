<?php


namespace Modules\WelcomeMessage\Service\WelcomeMessage;


use Illuminate\Validation\Rule;


trait WelcomeMessageServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
        ]);
    }
}
