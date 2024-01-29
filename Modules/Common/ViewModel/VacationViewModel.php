<?php


namespace Modules\Common\ViewModel;


use Modules\Common\Service\HolidayTypes\HolidayTypesService;
use Modules\Employee\Service\EmployeeService;
use Modules\School\Service\School\SchoolService;
class VacationViewModel
{

    public function schools()
    {
        return (new SchoolService())->active()['data'];
    }
    public function employees()
    {
        return (new EmployeeService())->active();
    }
    public function holidays(){
        return (new HolidayTypesService())->all([])['data'];
    }

}
