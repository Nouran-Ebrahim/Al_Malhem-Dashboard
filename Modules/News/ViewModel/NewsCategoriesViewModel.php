<?php


namespace Modules\News\ViewModel;


use Modules\Employee\Service\EmployeeService;
use Modules\News\Service\NewsCategory\NewsCategoryService;

class NewsCategoriesViewModel
{

    public function newsCategories()
    {
        $data['is_active'] = 1;
        return (new NewsCategoryService())->all($data)['data'];
    }


}
