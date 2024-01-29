<?php


namespace Modules\ScientificExcellence\Repository\Party;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\ScientificExcellence\Entities\Party;

class PartyRepository
{

    private $partyModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->partyModel = new Party();
    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Party');
            }
        }

        $party = $this->partyModel->create($data);
        if ($party) {
            foreach ($imageName as $value) {
                $party->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $party->fresh();
    }

    public function update(array $data)
    {
        // dd(request()->hasFile('source'));
        $party = $this->partyModel->find($data['id']);
        if (request()->hasFile('file')) {
            File::delete(public_path('uploads/Party/PDFs/' . $this->getImageName('PDFs', $party->file)));
            $file = request()->file('file');
            $fileName = $this->uploadFile($file, 'Party', 'PDFs');
            $data['file'] = $fileName;
        }
        $party->update($data);
        if (request()->hasFile('source')) {
            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Party');
            }
            foreach ($imageName as $value) {
                $party->images()->create([
                    'source' => $value,
                ]);
            }
        }


        return $party->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->partyModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->partyModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->partyModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {
        $today = date("Y-m-d");

        $party = $this->partyModel->with([
            'superiors' => function ($q) {
                $q->where('is_active', 1);
            },
            'images'
        ])->when((isset($data['filterDate']) && $data['filterDate'] === "next") && $data['filterDate'] != null, function ($q) use ($today) {
            //    dd(1);
            return $q->where('date', '>=', $today);
        })->when((isset($data['filterDate']) && $data['filterDate'] === "previos") && $data['filterDate'] != null, function ($q) use ($today) {
            return $q->where('date', '<', $today);
        })
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
        //    dd($party->get());
        return getCaseCollection($party, $data);
    }
    // public function active(array $data, $relation = [])
    // {

    //     $party = $this->partyModel->active()->with($relation)->orderBy('date', 'desc');

    //     return getCaseCollection($party, $data);
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

    //         File::delete(public_path('uploads/Party/' . $value->source));
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
