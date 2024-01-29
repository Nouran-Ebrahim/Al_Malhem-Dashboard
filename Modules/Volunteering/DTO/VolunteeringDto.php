<?php


namespace Modules\Volunteering\DTO;


class VolunteeringDto
{


    public $client_id;
    public $phone;
    public $is_active;
    public $name;
    public $email;
    public $details;
    public $gender;
    public $volunteering_type_id;
    public $id;

    public function __construct($request)
    {
        // dd($request->details);

        $this->details =  $request->get('details');
        $this->phone = $request->get('phone');
        $this->client_id = $request->get('client_id')??null;
        $this->id = $request->get('id')??null;
        // if ($request->hasFile('image')) $this->image   = $request->file('image');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
        $this->name = $request->get('name');
        $this->volunteering_type_id = $request->get('volunteering_type_id');
        $this->gender = $request->get('gender');
        $this->email = $request->get('email');
      
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        // if ($data['source'] == null) unset($data['image']);
        return $data;
    }

}
