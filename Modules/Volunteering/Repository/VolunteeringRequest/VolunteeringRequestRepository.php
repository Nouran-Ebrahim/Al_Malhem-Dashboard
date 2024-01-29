<?php


namespace Modules\Volunteering\Repository\VolunteeringRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;

use Modules\Volunteering\Entities\Volunteering;

use Modules\Volunteering\Entities\VolunteeringRequest;

class VolunteeringRequestRepository
{

    private $volunteeringRequestModel;
    use UploaderHelper;
    private $volunteeringModel;

    public function __construct()
    {
        $this->volunteeringRequestModel = new VolunteeringRequest();
        $this->volunteeringModel = new Volunteering();

    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'VolunteeringRequest');
            }
        }

        $volunteeringRequest = $this->volunteeringRequestModel->create($data);
        $volunteeringRequest->volunteeringTypes()->sync($data['volunteering_type_id']);

        if ($volunteeringRequest) {
            foreach ($imageName as $value) {
                $volunteeringRequest->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $volunteeringRequest->fresh();
    }
    public function join(array $data)
    {

        $volunteering = $this->volunteeringModel->where('client_id', $data['client_id'])->first();
        // dd($volunteering);
        $volunteering->volunteeringRequst()->sync($data['volunteering_request_id']);

        return $volunteering->fresh();
    }
    public function update(array $data)
    {
        // dd(request()->hasFile('source'));
        $volunteeringRequest = $this->volunteeringRequestModel->find($data['id']);

        $volunteeringRequest->update($data);
        $volunteeringRequest->volunteeringTypes()->sync($data['volunteering_type_id']);

        if (request()->hasFile('source')) {
            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'VolunteeringRequest');
            }
            foreach ($imageName as $value) {
                $volunteeringRequest->images()->create([
                    'source' => $value,
                ]);
            }
        }


        return $volunteeringRequest->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->volunteeringRequestModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->volunteeringRequestModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->volunteeringRequestModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation)
    {
        $today = date("Y-m-d");

        $volunteeringRequest = $this->volunteeringRequestModel->with($relation)
            ->when((isset($data['filterDate']) && $data['filterDate'] === "next") && $data['filterDate'] != null, function ($q) use ($today) {
            return $q->where('date', '>=', $today);
        })->when((isset($data['filterDate']) && $data['filterDate'] === "previos") && $data['filterDate'] != null, function ($q) use ($today) {
            return $q->where('date', '<', $today);
        })->when($data['volunteering_type_id'] ?? null, function ($q) use ($data) {
            $q->whereHas('volunteeringTypes', function ($q) use ($data) {
                return $q->where('volunteering_type_id', $data['volunteering_type_id']);
            });
        })->when($data['client_id'] ?? null,
                function ($q) use ($data) {
                    return $q->withCount([
                        'joines as has_join' => function ($query) use ($data) {
                            $query->where('client_id', $data['client_id']);
                        }
                    ]);
                }
            )
            ->when(
                $data['is_active'] ?? null,
                function ($q) use ($data) {
                    return $q->active();
                }
            )->when(
                $data['lastDaysCount'] ?? null,
                function ($q) use ($data) {

                    return
                        $q->where(
                            'created_at',
                            '>=',
                            Carbon::now()->subDays($data['lastDaysCount'])->toDateTimeString()
                        );
                }
            )
            // ->whereHas('superiors', function ($q) {
            //     $q->where('is_active', 1);
            // })
            ->orderBy('date', 'desc');

        if ($data['client_id'] ?? null) {
            $has_volunteering = Volunteering::query()->where('client_id', $data['client_id'])->count();
            return ['has_volunteering' => $has_volunteering,'data' =>getCaseCollection($volunteeringRequest, $data)];
        }
        //    dd($volunteeringRequest->get());
        return getCaseCollection($volunteeringRequest, $data);
    }
    // public function active(array $data, $relation = [])
    // {

    //     $volunteeringRequest = $this->volunteeringRequestModel->active()->with($relation)->orderBy('date', 'desc');

    //     return getCaseCollection($volunteeringRequest, $data);
    // }
    // public function deleteImages($id)
    // {
    //     $images = Image::whereHasMorph(
    //         'imagetable',
    //         [Occasion::class],
    //         function ($query) use ($id) {

    //             $query->where('imagetable_id', $id);
    //         }
    //     )->get();

    //     foreach ($images as  $value) {

    //         File::delete(public_path('uploads/VolunteeringRequest/' . $value->source));
    //     }
    //     // Image::whereHasMorph(
    //     //     'imagetable',
    //     //     [Occasion::class],
    //     //     // or you can use * for all
    //     //     function ($query) use ($id) {
    //     //         $query->where('imagetable_id', $id);
    //     //     }
    //     // )->delete();
    // }
}
