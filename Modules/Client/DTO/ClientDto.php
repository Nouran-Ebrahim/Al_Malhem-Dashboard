<?php


namespace Modules\Client\DTO;


class ClientDto
{

    public $name;
    public $phone;
    public $password;
    public $verify_code;
    public $image;
    public $is_active;

    public function __construct($request)
    {

        $this->name = $request->get('name');
        $this->phone = $request->get('phone');
        if ($request->get('password')) $this->password =  bcrypt($request->get('password'));
        if ($request->hasFile('image')) $this->image   = $request->file('image');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['password'] == null) unset($data['password']);
        if ($data['image'] == null) unset($data['image']);
        // $data['verify_code'] = rand(1000,9999);
        $data['verify_code'] = 9999;
        return $data;
    }

}
