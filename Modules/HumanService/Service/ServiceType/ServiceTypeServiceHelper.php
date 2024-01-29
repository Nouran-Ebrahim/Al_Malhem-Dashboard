<?php


namespace Modules\HumanService\Service\ServiceType;


use Illuminate\Validation\Rule;


trait ServiceTypeServiceHelper
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
