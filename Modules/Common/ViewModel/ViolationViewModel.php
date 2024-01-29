<?php


namespace Modules\Common\ViewModel;


use Modules\Common\Service\HolidayTypes\HolidayTypesService;
use Modules\Common\Service\Violation\ViolationService;
use Modules\Employee\Service\EmployeeService;
use Modules\School\Service\School\SchoolService;
class ViolationViewModel
{

    public function violations()
    {
        return (new ViolationService())->all()['data'];
    }


}
