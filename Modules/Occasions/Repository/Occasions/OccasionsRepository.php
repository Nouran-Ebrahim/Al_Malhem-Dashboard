<?php


namespace Modules\Occasions\Repository\Occasions;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\Occasions\Entities\Occasion;

class OccasionsRepository
{

    private $occasionsModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->occasionsModel = new Occasion();
    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Occasions');
            }
        }

        $occasions = $this->occasionsModel->create($data);
        if ($occasions) {
            foreach ($imageName as $value) {
                $occasions->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $occasions->fresh();
    }

    public function update(array $data)
    {
        // dd(request()->hasFile('source'));
        $occasions = $this->occasionsModel->find($data['id']);
        // dd(1);
        $occasions->update($data);
        if (request()->hasFile('source')) {
            // dd(1);
            //    $this->deleteImages($data['id']);
            // foreach ($occasions->images as $value) {
            //     File::delete(public_path('uploads/Occasions/' . $this->getImageName('Occasions', $value->source)));
            // }
            // $occasions->images()->delete();

            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Occasions');
            }
            foreach ($imageName as $value) {
                $occasions->images()->create([
                    'source' => $value,
                ]);
            }
        }


        return $occasions->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->occasionsModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->occasionsModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->occasionsModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {

        $occasions = $this->occasionsModel->with($relation)->when($data['occasions_category_id'] ?? null, function ($q) use ($data) {
            return $q->where('occasions_category_id', '=', $data['occasions_category_id']);
        })->when(
            $data['is_active'] ?? null,
            function ($q) use ($data) {
                return $q->whereHas('occasionsCategories', function ($q) {
                    $q->where('is_active', 1);
                })->active();
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
        );

        return getCaseCollection($occasions, $data);
    }
    // public function active(array $data, $relation = [])
    // {

    //     $occasions = $this->occasionsModel->active()->with($relation)->when($data['occasions_category_id'] ?? null, function ($q) use ($data) {
    //         return $q->where('occasions_category_id', '=', $data['occasions_category_id']);
    //     });
    //     // dd($occasions->get());
    //     return getCaseCollection($occasions, $data);
    //     // return $occasions->get();
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

    //         File::delete(public_path('uploads/Occasions/' . $value->source));
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
