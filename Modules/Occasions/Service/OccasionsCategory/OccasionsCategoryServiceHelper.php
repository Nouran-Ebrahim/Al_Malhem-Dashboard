<?php


namespace Modules\Occasions\Service\OccasionsCategory;


use Illuminate\Validation\Rule;


trait OccasionsCategoryServiceHelper
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
