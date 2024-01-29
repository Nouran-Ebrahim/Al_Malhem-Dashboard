<?php


namespace Modules\HumanService\DTO;


class ServiceDto
{


   
    public $description;
    public $source;
    public $is_active;
    public $type;
    public $service_type_id;
    public $id;
    public $client_id;
    public function __construct($request)
    {
        //dd($request);
        $this->type = $request['type'];
        $this->description = $request['description'];
        $this->service_type_id = $request['service_type_id'];
        $this->id = $request['id'] ?? null;
        $this->client_id = $request['client_id'];
        $this->is_active   = isset($request['is_active']) ? 1 : 0;

        if (request()->hasFile('source')) $this->source   = request()->file('source');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['source'] == null) unset($data['source']);
        return $data;
    }
}
