<?php


namespace Modules\ScientificExcellence\ViewModel;


use Modules\Employee\Service\EmployeeService;
use Modules\ScientificExcellence\Service\Party\PartyService;

class SuperiorViewModel
{

    public function parties()
    {
        $data['is_active'] = 1;
        return (new PartyService())->all($data)['data'];
    }


}
