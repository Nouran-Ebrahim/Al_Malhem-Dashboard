<?php


namespace Modules\Calender\Service\Calender;


use Illuminate\Validation\Rule;


trait CalenderServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
           
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            
        ]);
    }
}
