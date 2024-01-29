<?php


namespace Modules\HumanService\Repository\Service;

use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\HumanService\Entities\Service;

class ServiceRepository
{

    private $serviceModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->serviceModel = new Service();
    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Service');
            }
        }
        $service = $this->serviceModel->create($data);
        if ($service) {
            foreach ($imageName as $value) {
                $service->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $service->fresh();
    }

    public function update(array $data)
    {
        $service = $this->serviceModel->find($data['id']);
        $service->update($data);
        if (request()->hasFile('source')) {
            // $this->deleteImages($data['id']);
            // foreach ($service->images as $value) {
            //     File::delete(public_path('uploads/Service/' . $this->getImageName('Service', $value->source)));
            // }
            // $service->images()->delete();
            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Service');
            }

            foreach ($imageName as $value) {
                $service->images()->create([
                    'source' => $value,
                ]);
            }
        }


        return $service->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->serviceModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->serviceModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->serviceModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {

        $service = $this->serviceModel->with($relation)->when($data['service_type_id'] ?? null, function ($q) use ($data) {
            return $q->where('service_type_id', '=', $data['service_type_id']);
        })->when($data['type'] ?? null, function ($q) use ($data) {
            return $q->where('type', '=', $data['type']);
        })->when($data['is_active'] ?? null, function ($q) use ($data) {
            return $q->whereHas('serviceType', function ($q) {
                $q->where('is_active', 1);
            })->active();
        })->orderBy('created_at','desc');

        return getCaseCollection($service, $data);

    }

}
