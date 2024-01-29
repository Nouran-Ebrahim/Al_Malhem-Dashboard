<?php


namespace Modules\HumanService\Repository\ServiceType;
use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;


use Modules\HumanService\Entities\ServiceType;

class ServiceTypeRepository
{

    private $ServiceTypeModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->ServiceTypeModel = new ServiceType();
    }

    public function create(array $data){

        $serviceType = $this->ServiceTypeModel->create($data);
        return $serviceType->fresh();
    }

    public function update(array $data){
        $serviceType = $this->ServiceTypeModel->find($data['id']);

        $serviceType->update($data);
        return $serviceType->fresh();
    }

    public function find($id){
        return $this->ServiceTypeModel->whereId($id)->first();
    }
    public function findByIds($ids){
        return $this->ServiceTypeModel->whereIn('id',$ids)->get();
    }

    public function delete($id){

        $items = $this->ServiceTypeModel->where('id',$id)->delete();

    }

    public function all(array $data)
    {
        $serviceType = $this->ServiceTypeModel->when($data['is_active'] ?? null, function ($q) use ($data) {
                return $q->active();
            });
        return getCaseCollection($serviceType,$data);
    }
    // public function active(array $data)
    // {
    //     $serviceType = $this->ServiceTypeModel->active();
    //     return getCaseCollection($serviceType,$data);
    // }

}
