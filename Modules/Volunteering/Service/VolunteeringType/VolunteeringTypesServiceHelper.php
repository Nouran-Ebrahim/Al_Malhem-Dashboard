<?php


namespace Modules\Volunteering\Service\VolunteeringType;


use Illuminate\Validation\Rule;


trait VolunteeringTypesServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'color'=>'required'
           
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
          'color'=>'required'
        ]);
    }
}
