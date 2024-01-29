<?php


namespace Modules\Occasions\DTO;


class OccasionsCategoryDto
{

   
    public $title;
    public $color;
   
    public $is_active;
    public $id;

    public function __construct($request)
    {
//dd($request);
        $this->title = $request['title'];
        $this->color = $request['color'];
        $this->is_active   = isset($request['is_active']) ? 1 :0;
        $this->id = $request['id'] ?? null;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        // if ($data['image'] == null) unset($data['image']);
        return $data;
    }

}
