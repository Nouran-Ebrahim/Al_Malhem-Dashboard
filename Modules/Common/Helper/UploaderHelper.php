<?php


namespace Modules\Common\Helper;


use Intervention\Image\Facades\Image;

trait UploaderHelper
{

    public function upload($imageFromRequest, $imageFolder, $resize = false)
    {
        if (!file_exists(public_path('uploads/'.$imageFolder))) {
            mkdir(public_path('uploads/'.$imageFolder), 0777, true);
        }

        $fileName = time() . $imageFromRequest->getClientOriginalName();
        $location = public_path('uploads/' . $imageFolder . '/' . $fileName);

        $image = Image::make($imageFromRequest);
//        $image->resize(500,500);
        $image->save($location, 50);

        # Optional Resize.
        if ($resize == true) {
            $image->resize(100, 70);
            $newlocation = public_path('uploads/' . $imageFolder . '/thumb' . '/' . $fileName);
            $image->save($newlocation, 40);
        }


        return $fileName;
    }

    public function uploadFile($fileFromRequest,$fileFolder,$subFolder=""){

//        $fileName = time().'.'.$fileFromRequest->getClientOriginalExtension();
        $fileName = time().'.'.$fileFromRequest->getClientOriginalName();
        $location = public_path('uploads/'. $fileFolder . '/'.$subFolder.'/');
        $fileFromRequest->move($location, $fileName);

        return $fileName;

    }

    public function getImageName($folderName,$imagePath)
    {

        $needle = $folderName.'/';
        // dd($imagePath,$needle);
        return substr($imagePath, strpos($imagePath, $needle) + strlen($needle));
    }

}
