<?php


namespace Modules\Volunteering\ViewModel;


use Modules\Client\Entities\Client;
use Modules\Employee\Service\EmployeeService;
use Modules\Volunteering\Service\VolunteeringType\VolunteeringTypesService;
use Modules\Client\Service\ClientService;

class VolunteeringViewModel
{

    public function VolunteeringTypes()
    {
        $data['is_active'] = 1;
        return (new VolunteeringTypesService())->all($data)['data'];
    }

    public function clients()
    {
        return (new ClientService())->active();
    }
    public function clientWithNoVolunteering()
    {
        $clientWithNoVolunteering = Client::active()->whereDoesntHave('volunteering')->get();
        return $clientWithNoVolunteering;
    }
}
