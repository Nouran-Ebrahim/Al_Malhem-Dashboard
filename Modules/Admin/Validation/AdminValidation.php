<?php


namespace Modules\Admin\Validation;


trait AdminValidation
{
    protected function validateStore($data){
        return validator($data,[
            'name'=>'required|max:191',
            'email'=>'required|unique:admins,email',
            'phone' => 'required',
            'password' => 'required',
            'role_id'=>'required|exists:roles,id',
            'school_id'=> 'required_if:role_id,==,2'
        ]);

    }

    protected function validateUpdate($data,$id){
        return validator($data,[
            'name'=>'required|max:191',
            'email'=>'required|unique:admins,email,'.$id,
            'phone' => 'required',
            'role_id'=>'required|exists:roles,id',
            'school_id'=> 'required_if:role_id,==,2'

        ]);

    }

}
