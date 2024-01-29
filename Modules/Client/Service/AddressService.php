<?php


namespace Modules\Client\Service;


use Modules\Client\Entities\Address;

class AddressService
{
    function findAll(){
        return Address::all();
    }

    function findById($id){
        return Address::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Address::where($key, $value)->get();
    }

    function save($data){
        return Address::create($data);
    }

    function delete($id)
    {
        $Address = $this->findById($id);
        $Address->delete();
    }

}
