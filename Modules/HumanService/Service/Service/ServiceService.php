<?php


namespace Modules\HumanService\Service\Service;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\HumanService\DTO\ServiceDto;


use Illuminate\Support\Facades\DB;
use Modules\HumanService\Entities\Service;
use Modules\HumanService\Repository\Service\ServiceRepository;

class ServiceService
{

    use ServiceServiceHelper, UploaderHelper;

    protected $serviceRepository;

    public function __construct()
    {
        $this->serviceRepository = new ServiceRepository();
    }

    public function create(array $data)
    {
        //   dd($data);
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationCreate($data);
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new ServiceDto($data))->dataFromRequest();


            $item = $this->serviceRepository->create($data);


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
            $data = (new ServiceDto($data))->dataFromRequest();

            $item = $this->serviceRepository->update($data);
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
            $items = $this->serviceRepository->all($data, $relation);
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
    //         $items = $this->serviceRepository->active($data, $relation);
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
            $item = $this->serviceRepository->find($id);
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
            $item = $this->serviceRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            //    $this->serviceRepository->deleteImages($id);
            foreach ($item->images as $value) {
                File::delete(public_path('uploads/Service/' . $this->getImageName('Service', $value->source)));
            }
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
            $item = $this->serviceRepository->find($id);
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

    function deleteServicePhoto($id)
    {
        // dd($id);
        $ServiceImage =  Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/Service/' . $this->getImageName('Service', $ServiceImage->source)));
        return $ServiceImage->delete();
    }
}
