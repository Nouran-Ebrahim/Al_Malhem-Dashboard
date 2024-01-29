<?php


namespace Modules\Volunteering\Repository\Volunteering;

use Illuminate\Support\Facades\Log;
use Modules\Volunteering\Entities\Volunteering;
use Modules\Volunteering\Entities\VolunteeringType;

class VolunteeringRepository
{

    private $volunteeringModel;

    public function __construct()
    {
        $this->volunteeringModel = new Volunteering();
    }

    public function create(array $data)
    {
        //  dd($data);
        $volunteering = $this->volunteeringModel->create($data);


        $volunteering->volunteeringTypes()->sync($data['volunteering_type_id']);

        return $volunteering->fresh();
    }

    public function update(array $data)
    {

        $volunteering = $this->volunteeringModel->find($data['id']);
        // dd($data['volunteering_type_id']);
        $data['client_id'] = $volunteering->client_id;
        // dd($data);
        $volunteering->update($data);

        $volunteering->volunteeringTypes()->sync($data['volunteering_type_id']);

        return $volunteering->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->volunteeringModel->with($relation)->whereId($id)->first();
    }

    public function findByIds($ids)
    {
        return $this->volunteeringModel->whereIn('id', $ids)->get();
    }


    public function delete($id)
    {

        $items = $this->volunteeringModel->where('id', $id)->delete();
    }

    public function all(array $data, $ralation)
    {
        $volunteering = $this->volunteeringModel->with($ralation)
            ->when($data['volunteering_type_id'] ?? null, function ($q) use ($data) {
                $q->whereHas('volunteeringTypes', function ($q) use ($data) {
                    return $q->where('volunteering_type_id', $data['volunteering_type_id']);
                });
            })->when($data['client_id'] ?? null, function ($q) use ($data) {
                $q->where('client_id', $data['client_id']);
            })->when($data['is_active'] ?? null, function ($q) use ($data) {
                return $q->active();
            });

        if ($data['auth_id'] ?? null) {
            $has_volunteering = (clone $volunteering)->where('client_id', $data['auth_id'])->count();
            return ['has_volunteering' => $has_volunteering];
        }
        return getCaseCollection($volunteering, $data);
    }
}
