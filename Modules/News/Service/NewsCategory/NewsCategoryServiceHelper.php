<?php


namespace Modules\News\Service\NewsCategory;


use Illuminate\Validation\Rule;


trait NewsCategoryServiceHelper
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
