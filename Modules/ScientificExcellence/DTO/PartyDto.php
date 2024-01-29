<?php


namespace Modules\ScientificExcellence\DTO;


class PartyDto
{
    public $title;
    public $description;
    public $source;
    public $file;
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
        if (request()->hasFile('file')) $this->file   = request()->file('file');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        
        if ($data['source'] == null) unset($data['source']);
        if ($data['file'] == null) unset($data['file']);
        // dd($data);
        return $data;
    }
}
