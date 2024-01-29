<?php


namespace Modules\Occasions\Service\Occasions;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\Occasions\DTO\OccasionsDto;


use Illuminate\Support\Facades\DB;
use Modules\Occasions\Entities\Occasion;
use Modules\Occasions\Repository\Occasions\OccasionsRepository;

class OccasionsService
{

    use OccasionsServiceHelper, UploaderHelper;

    protected $occasionsRepository;

    public function __construct()
    {
        $this->occasionsRepository = new OccasionsRepository();
    }

    public function create(array $data)
    {
        //  dd($data);
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationCreate($data);
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new OccasionsDto($data))->dataFromRequest();



            $item = $this->occasionsRepository->create($data);
            // dd($item-> images());


            DB::commit();
            return return_msg(true, 'Success', $item);
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationUpdate($data);
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new OccasionsDto($data))->dataFromRequest();
// dd($data);
            $item = $this->occasionsRepository->update($data);
            DB::commit();

            return return_msg(true, 'Success', $item);
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    public function all(array $data, $relation = [])
    {
        try {
            $items = $this->occasionsRepository->all($data, $relation);
            return return_msg(true, 'Success', $items);
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }
    // public function active(array $data, $relation = [])
    // {
    //     try {
    //         $items = $this->occasionsRepository->active($data, $relation);
    //         return return_msg(true, 'Success', $items);
    //     } catch (\Exception $exception) {
    //         DB::rollBack();
    //         handleExceptionDD($exception);
    //         return return_msg(false, 'Success', [
    //             'validation_errors' => [
    //                 'error_id' => [__('messages.server_error')],
    //             ],
    //         ]);
    //     }
    // }
    public function find($id)
    {
        try {
            $item = $this->occasionsRepository->find($id);
            return return_msg($item ? true : false, 'Success', $item);
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    public function delete($id, $relation = [])
    {
        // dd($id);
        try {
            $item = $this->occasionsRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            // $this->occasionsRepository->deleteImages($id);
            // // dd($item->images);
            foreach ($item->images as $value) {
                File::delete(public_path('uploads/Occasions/' . $this->getImageName('Occasions', $value->source)));
                // log::info(public_path('uploads/Occasions/' . $this->getImageName('Occasions', $value->source)));
            }
            // dd(1);
            $item->images()->delete();
            $item->delete();
            return return_msg(true, 'Success');
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }
    public function activate($id)
    {
        try {
            $item = $this->occasionsRepository->find($id);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            $item->is_active = !$item->is_active;
            $item->save();
            return return_msg(true, 'Success');
        } catch (\Exception $exception) {
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }
    function deleteOccasionsPhotos($id)
    {
        // dd($id);
        $OccasionsImage =  Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/Occasions/' . $this->getImageName('Occasions', $OccasionsImage->source)));
        return $OccasionsImage->delete();
    }
}
