<?php


namespace Modules\Client\Service;

use Modules\Client\Entities\Point;

class PointService
{
    function findAll(){
        return Point::all();
    }

    function findById($id){
        return Point::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Point::where($key, $value)->get();
    }

    function save($data){
        return Point::create($data);
    }

    function delete($id)
    {
        $Point = $this->findById($id);
        $Point->delete();
    }

    function getTotalPoints($client_id)
    {
        return Point::NotConverted()->where('client_id',$client_id)->sum('points');
    }

    function convertPointsToBalance($points)
    {
        return (int) ($points / 100) * getSetting('points_value');
    }

    function makePointsConverted($client_id)
    {
        Point::NotConverted()->where('client_id',$client_id)->update(['is_converted'=>1]);
    }

}
