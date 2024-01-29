<?php


namespace Modules\ScientificExcellence\Service\Party;


use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\File;


trait PartyServiceHelper
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
            'date'=>'required',
            'file'=> 'max:10000|mimes:pdf'
        ]);
    }
}
