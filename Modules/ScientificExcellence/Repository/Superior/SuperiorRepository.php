<?php


namespace Modules\ScientificExcellence\Repository\Superior;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\ScientificExcellence\Entities\Superior;

class SuperiorRepository
{

    private $superiorModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->superiorModel = new Superior();
    }

    public function create(array $data)
    {
        // dd(request()->hasFile('personal'));
        // dd(request()->hasFile('personal'));
        if ((request()->hasFile('certification'))) {

            $certification = request()->file('certification');
            $certificationName = $this->uploadFile($certification, 'Superior', 'Certification');

            $data['certification'] = $certificationName;
        }
        if (request()->hasFile('personal')) {

            $personal = request()->file('personal');

            $personalName = $this->uploadFile($personal, 'Superior', 'Personal');

            $data['personal'] = $personalName;
        }
        $superior = $this->superiorModel->create($data);

        return $superior->fresh();
    }

    public function update(array $data)
    {
        // dd(request()->hasFile('source'));
        $superior = $this->superiorModel->find($data['id']);
        // dd($this->getImageName('Certification', $superior->certification));
        if (request()->hasFile('certification')) {
            File::delete(public_path('uploads/Superior/Certification/' . $this->getImageName('Certification', $superior->certification)));
            $certification = request()->file('certification');
            $certificationName = $this->uploadFile($certification, 'Superior', 'Certification');
            $data['certification'] =  $certificationName;
        }


        if (request()->hasFile('personal')) {
            File::delete(public_path('uploads/Superior/Personal/' . $this->getImageName('Personal', $superior->personal)));
            $personal = request()->file('personal');
            $personalName = $this->uploadFile($personal, 'Superior', 'Personal');
            $data['personal'] = $personalName;
        }

        $superior->update($data);

        return $superior->fresh();
    }
    public function addParty(array $data)
    {
        // dd(request()->hasFile('source'));
        $superior = $this->superiorModel->find($data['id']);

        $superior->update([
            'is_active' => 1,
            'party_id' => $data['party_id'],
        ]);

        return $superior->fresh();
    }
    public function find($id, $relation = [])
    {
        return $this->superiorModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->superiorModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->superiorModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {
        $today = date("Y-m-d");
        // dd($today);
        // dd($data);
        $superior = $this->superiorModel->with($relation)
            ->when(
                $data['is_active'] ?? null,
                function ($q) use ($data) {
                    return $q->active();
                }
            )->when(
                $data['lastMonth'] ?? null,
                function ($q) {

                    return
                        $q->where(
                            'created_at',
                            '>=',
                            Carbon::now()->subDays(30)->toDateTimeString()
                        );
                }
            );

        return getCaseCollection($superior, $data);
    }
    // public function active(array $data, $relation = [])
    // {

    //     $superior = $this->superiorModel->active()->with($relation)->when($data['superior_category_id'] ?? null, function ($q) use ($data) {
    //         return $q->where('superior_category_id', '=', $data['superior_category_id']);
    //     });
    //     // dd($superior->get());
    //     return getCaseCollection($superior, $data);
    //     // return $superior->get();
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

    //         File::delete(public_path('uploads/Superior/' . $value->source));
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
