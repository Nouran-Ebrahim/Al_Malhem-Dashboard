<?php


namespace Modules\Meeting\ViewModel;

// use Modules\Client\Entities\Client;
use Modules\Employee\Service\EmployeeService;
use Modules\Client\Service\ClientService;

class ClientViewModel
{

    public function clients()
    {
        return (new ClientService())->active();
    }
}
