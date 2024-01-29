<?php


namespace Modules\Occasions\ViewModel;


use Modules\Occasions\Service\OccasionsCategory\OccasionsCategoryService;

class OccasionsCategoriesViewModel
{

    public function OccasionsCategories()
    {
        $data['is_active'] = 1;
        return (new OccasionsCategoryService())->all($data)['data'];
    }


}
