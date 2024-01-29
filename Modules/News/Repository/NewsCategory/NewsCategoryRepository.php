<?php


namespace Modules\News\Repository\NewsCategory;
use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;


use Modules\News\Entities\NewsCategory;

class NewsCategoryRepository
{

    private $NewsCategoryModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->NewsCategoryModel = new NewsCategory();
    }

    public function create(array $data){

        $newsCategory = $this->NewsCategoryModel->create($data);
        return $newsCategory->fresh();
    }

    public function update(array $data){
        $newsCategory = $this->NewsCategoryModel->find($data['id']);

        $newsCategory->update($data);
        return $newsCategory->fresh();
    }

    public function find($id){
        return $this->NewsCategoryModel->whereId($id)->first();
    }
    public function findByIds($ids){
        return $this->NewsCategoryModel->whereIn('id',$ids)->get();
    }

    public function delete($id){

        $items = $this->NewsCategoryModel->where('id',$id)->delete();

    }

    public function all(array $data)
    {
        $newsCategory = $this->NewsCategoryModel->when($data['is_active'] ?? null, function ($q) use ($data) {
                return $q->active();
            });
        return getCaseCollection($newsCategory,$data);
    }
    // public function active(array $data)
    // {
    //     $newsCategory = $this->NewsCategoryModel->active();
    //     return getCaseCollection($newsCategory,$data);
    // }

}
