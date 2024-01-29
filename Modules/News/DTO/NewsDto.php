<?php


namespace Modules\News\DTO;


class NewsDto
{


    public $title;
    public $description;
    public $source;
    public $is_active;

    public $news_category_id;
    public $id;

    public function __construct($request)
    {
        //dd($request);
        $this->title = $request['title'];
        $this->description = $request['description'];
        $this->news_category_id = $request['news_category_id'] ?? null;
        $this->id = $request['id'] ?? null;
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
