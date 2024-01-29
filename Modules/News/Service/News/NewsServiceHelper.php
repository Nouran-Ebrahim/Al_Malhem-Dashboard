<?php


namespace Modules\News\Service\News;


use Illuminate\Validation\Rule;


trait NewsServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            // 'news_category_id'=>'required|nullable'
            // 'image' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            // 'news_category_id'=>'required|nullable'
        ]);
    }
}
