<?php


namespace Modules\Volunteering\Repository\VolunteeringType;
use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;


use Modules\Volunteering\Entities\VolunteeringType;

class VolunteeringTypesRepository
{

    private $volunteeringTypeModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->volunteeringTypeModel = new VolunteeringType();
    }

    public function create(array $data){

        $newsCategory = $this->volunteeringTypeModel->create($data);
        return $newsCategory->fresh();
    }

    public function update(array $data){
        $newsCategory = $this->volunteeringTypeModel->find($data['id']);

        $newsCategory->update($data);
        return $newsCategory->fresh();
    }

    public function find($id){
        return $this->volunteeringTypeModel->whereId($id)->first();
    }
    public function findByIds($ids){
        return $this->volunteeringTypeModel->whereIn('id',$ids)->get();
    }

    public function delete($id){

        $items = $this->volunteeringTypeModel->where('id',$id)->delete();

    }

    public function all(array $data)
    {
        $newsCategory = $this->volunteeringTypeModel->when($data['is_active'] ?? null, function ($q) use ($data) {
            return $q->active();
        });
        return getCaseCollection($newsCategory,$data);
    }
    // public function active(array $data)
    // {
    //     $newsCategory = $this->volunteeringTypeModel->active();
    //     return getCaseCollection($newsCategory,$data);
    // }

}
