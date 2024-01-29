<?php


namespace Modules\ScientificExcellence\DTO;


class SuperiorDto
{
    protected $fillable = ['name', 'certification', 'personal', 'gender', 'civil', 'year', 'specialization', 'gpa', "phone", 'parent_phone', 'is_active', 'party_id'];

    public $name;
    public $gender;
    public $personal;
    public $certification;
    public $civil;
    public $year;
    public $specialization;
    public $gpa;
    public $phone;
    public $parent_phone;
    public $is_active;
    public $id;
    public $party_id;
    public function __construct($request)
    {
        //dd($request);
        $this->name = $request['name'];
        $this->gender = $request['gender'];
        $this->civil = $request['civil'];
        $this->specialization = $request['specialization'];
        $this->year = $request['year'];
        $this->phone = $request['phone'];
        $this->parent_phone = $request['parent_phone'];
        $this->gpa = $request['gpa'];
        $this->is_active   = isset($request['is_active']) ? 1 : 0;
        $this->id = $request['id'] ?? null;
        $this->party_id = $request['party_id'] ?? null;
        if (request()->hasFile('certification')) $this->certification   = request()->file('certification');
        if (request()->hasFile('personal')) $this->personal   = request()->file('personal');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        // dd($data);
        if ($data['certification'] == null) unset($data['certification']);
        if ($data['personal'] == null) unset($data['personal']);
        return $data;
    }
}
