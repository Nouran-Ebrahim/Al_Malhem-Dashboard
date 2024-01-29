<?php


namespace Modules\ScientificExcellence\Service\Superior;


use Illuminate\Validation\Rule;


trait SuperiorServiceHelper
{
    protected $fillable = ['name', 'certification', 'personal', 'gender', 'civil', 'year', 'specialization', 'gpa', "phone", 'parent_phone', 'is_active', 'party_id'];

    protected function validationCreate($data)
    {
        return validator($data,[
            'name' => 'required',
            'gender' => 'required',
            'civil'=>'required',
            'year' => 'required',
            'specialization' => 'required',
            'gpa' => 'required',
            'phone' => 'required',
            'parent_phone' => 'required',
            'certification' => 'required',
            'party_id' => 'required_if:is_active,==,1',
            // 'image' => 'required',
        ]);
    }
    protected function validationUpdate($data)
    {
        return validator($data,[
            'name' => 'required',
            'gender' => 'required',
            'civil' => 'required',
            'year' => 'required',
            'specialization' => 'required',
            'gpa' => 'required',
            'phone' => 'required',
            // 'certification' => 'required',
            'parent_phone' => 'required',
            'party_id' => 'required_if:is_active,==,1',
        ]);
    }
}
