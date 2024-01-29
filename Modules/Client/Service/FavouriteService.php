<?php


namespace Modules\Client\Service;


use Illuminate\Support\Facades\DB;
use Modules\Client\Entities\Favourite;

class FavouriteService
{
    function findAll(){
        return Favourite::all();
    }

    function findById($id){
        return Favourite::whereId($id)->first();
    }

    function findBy($key, $value,$relation=[])
    {
        return Favourite::with($relation)->where($key, $value)->get();
    }

    function findByMultiKeys($key, $value,$key1, $value1)
    {
        return Favourite::where($key, $value)->where($key1, $value1)->first();
    }

    function save($data){
        return Favourite::create($data);
    }

    function delete($id)
    {
        $Favourite = $this->findById($id);
        $Favourite->delete();
    }

}
