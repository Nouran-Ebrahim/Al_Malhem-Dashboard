<?php


namespace Modules\Client\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Client\Entities\Client;
use Modules\Common\Helper\UploaderHelper;

class ClientService
{
    use UploaderHelper;
    function findAll(){
        return Client::all();
    }
    function active()
    {
        return Client::active()->get();
    }
    function findById($id){
        return Client::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Client::where($key, $value)->get();
    }

    function save($data){
        if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'Client');
            $data['image'] = $imageName;
        }
        return Client::create($data);
    }

    function update($id,$data){
        $Client = $this->findById($id);
        if (request()->hasFile('image')){
            File::delete(public_path('uploads/Client/'.$this->getImageName('Client',$Client->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'Client');
            $data['image'] = $imageName;
        }
        $Client->update($data);
        return $Client;
    }

    function activate($id){
        $Client = $this->findById($id);
        $Client->is_active = !$Client->is_active;
        $Client->save();
    }
    function delete($id)
    {
        $Client = $this->findById($id);
        File::delete(public_path('uploads/Client/'.$this->getImageName('Client',$Client->image)));
        $Client->delete();
    }

}
