<?php


namespace Modules\WelcomeMessage\DTO;


class WelcomeMessageDto
{


    public $title;
    public $description;
    public $is_active;

    public $id;
    public $image;

    public function __construct($request)
    {
        //dd($request);
        $this->title = $request['title'];

        $this->description = $request['description'];

        $this->id = $request['id'] ?? null;
        if (request()->hasFile('image'))
            $this->image = request()->file('image');
        $this->is_active = isset($request['is_active']) ? 1 : 0;

    }

    public function dataFromRequest()
    {
        $data = json_decode(json_encode($this), true);
        if ($data['image'] == null)
            unset($data['image']);
        return $data;
    }
}
