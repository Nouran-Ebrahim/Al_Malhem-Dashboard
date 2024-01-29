<?php


namespace Modules\Volunteering\Service\VolunteeringRequest;


use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\File;


trait VolunteeringRequestServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data,[
            'title' => 'required',
            'description' => 'required',
            'date'=>'required',
            'volunteering_type_id' => 'required'
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
