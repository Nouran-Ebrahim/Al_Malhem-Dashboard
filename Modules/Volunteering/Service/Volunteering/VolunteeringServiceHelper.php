<?php


namespace Modules\Volunteering\Service\Volunteering;


use Illuminate\Validation\Rule;


trait VolunteeringServiceHelper
{

    protected function validationCreate($data)
    {
        return validator($data, [
            'volunteering_type_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'details' => 'required',
            'gender' => 'required',
            'client_id' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data, [
            'volunteering_type_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'details' => 'required',
            'gender' => 'required',
            // 'client_id' => 'required',
        ]);
    }
}