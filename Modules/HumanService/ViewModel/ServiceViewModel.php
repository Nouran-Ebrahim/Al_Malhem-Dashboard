<?php


namespace Modules\HumanService\ViewModel;

use Modules\Client\Service\ClientService;
use Modules\Employee\Service\EmployeeService;
use Modules\HumanService\Service\ServiceType\ServiceTypeService;


class ServiceViewModel
{

    public function serviceTypes()
    {
        $data['is_active']=1;
        return (new ServiceTypeService())->all($data)['data'];
    }

    public function clients()
    {
        return (new ClientService())->active();
    }
}
