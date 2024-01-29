<?php


namespace Modules\Volunteering\DTO;


class VolunteeringRequestDto
{
    public $title;
    public $description;
    public $source;
    public $volunteering_type_id;
    public $date;
    public $is_active;
    public $id;
    public function __construct($request)
    {
        //dd($request);
        $this->title = $request['title'];
        $this->description = $request['description'];
        $this->date = $request['date'];
        $this->is_active   = isset($request['is_active']) ? 1 : 0;
        $this->id = $request['id'] ?? null;
        if (request()->hasFile('source')) $this->source   = request()->file('source');
        $this->volunteering_type_id   = $request['volunteering_type_id'];
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);

        if ($data['source'] == null) unset($data['source']);
        // dd($data);
        return $data;
    }
}
