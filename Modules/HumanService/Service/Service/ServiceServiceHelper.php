<?php


namespace Modules\HumanService\Service\Service;


use Illuminate\Validation\Rule;


trait ServiceServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'client_id'=>'required',
            'description' => 'required',
            'service_type_id'=>'required',
            'type'=>'in:offer,request'
            // 'image' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'client_id' => 'required',
            'description' => 'required',
            'service_type_id' => 'required',
            'type' => 'in:offer,request'
        ]);
    }
}
