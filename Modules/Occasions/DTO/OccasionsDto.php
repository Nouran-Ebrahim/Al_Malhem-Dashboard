<?php


namespace Modules\Occasions\DTO;


class OccasionsDto
{

   
    public $title;
    public $description;
    public $source;
    public $occasions_category_id;
    public $date;
    public $is_active;
    public $id;
    public function __construct($request)
    {
//dd($request);
        $this->title = $request['title'];
        $this->description = $request['description'];
        $this->date = $request['date'];
        $this->occasions_category_id = $request['occasions_category_id']??null;
        $this->is_active   = isset($request['is_active']) ? 1 :0;
        $this->id = $request['id'] ?? null;
        if (request()->hasFile('source')) $this->source   = request()->file('source');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['source'] == null) unset($data['source']);
        return $data;
    }

}
