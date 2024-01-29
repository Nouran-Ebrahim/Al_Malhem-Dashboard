<?php


namespace Modules\Occasions\Service\Occasions;


use Illuminate\Validation\Rule;


trait OccasionsServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'date'=>'required',
            // 'image' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'date'=>'required'
        ]);
    }
}
