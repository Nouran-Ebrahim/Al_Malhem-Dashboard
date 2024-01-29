<?php


namespace Modules\Meeting\DTO;


class MeetingDto
{


    public $title;
    public $description;
    public $source;
    public $is_active;
    public $long;
    public $lat;
    public $phone;
    public $client_id;
     public $id;
    public $workingHours;
    public function __construct($request)
    {
//dd($request);
        $this->title = $request['title'];
        $this->description = $request['description'];
        $this->long = $request['long'];
        $this->lat = $request['lat'];
        $this->phone = $request['phone'];
        $this->workingHours = $request['workingHours'];
        $this->client_id = $request['client_id'];
        $this->id = $request['id']??null;
        $this->is_active   = isset($request['is_active']) ? 1 :0;

        if (request()->hasFile('source')) $this->source   = request()->file('source');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
//        if ($data['source'] == null) unset($data['source']);
        return $data;
    }

}
