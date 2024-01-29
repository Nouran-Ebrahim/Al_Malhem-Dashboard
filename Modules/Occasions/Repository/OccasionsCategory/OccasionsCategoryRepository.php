<?php


namespace Modules\Occasions\Repository\OccasionsCategory;

use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;


use Modules\Occasions\Entities\OccasionsCategory;

class OccasionsCategoryRepository
{

    private $OccasionsCategoryModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->OccasionsCategoryModel = new OccasionsCategory();
    }

    public function create(array $data)
    {

        $occasionsCategory = $this->OccasionsCategoryModel->create($data);
        return $occasionsCategory->fresh();
    }

    public function update(array $data)
    {

        $occasionsCategory = $this->OccasionsCategoryModel->find($data['id']);

        $occasionsCategory->update($data);
        return $occasionsCategory->fresh();
    }

    public function find($id)
    {
        return $this->OccasionsCategoryModel->whereId($id)->first();
    }
    public function findByIds($ids)
    {
        return $this->OccasionsCategoryModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->OccasionsCategoryModel->where('id', $id)->delete();
    }

    public function all(array $data)
    {
        $occasionsCategory = $this->OccasionsCategoryModel->when(
            $data['is_active'] ?? null,
            function ($q) use ($data) {
                $q->active();
            }
        );
        return getCaseCollection($occasionsCategory, $data);
    }
    // public function active(array $data)
    // {
    //     $occasionsCategory = $this->OccasionsCategoryModel->active();
    //     return getCaseCollection($occasionsCategory, $data);
    // }
}
