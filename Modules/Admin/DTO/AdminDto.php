<?php


namespace Modules\Admin\DTO;


class AdminDto
{

    public $name;
    public $email;
    public $password;
    public $phone;
    public $image;
    public $is_active;
    public $role_id;
    public $school_id;

    public function __construct($request)
    {

        $this->name = $request->get('name');
        $this->email = $request->get('email');
        $this->role_id = $request->get('role_id');
        $this->school_id = $request->get('school_id');
        if ($request->get('password')) $this->password =  bcrypt($request->get('password'));
        $this->phone = $request->get('phone');
        if ($request->hasFile('image')) $this->image   = $request->file('image');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['password'] == null) unset($data['password']);
        if ($data['image'] == null) unset($data['image']);
        if ($data['school_id'] == null) unset($data['school_id']);
        return $data;
    }

    public function adminDataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        $data = array_filter($data);
        $data['role_id'] = 1;
        return $data;
    }

}
