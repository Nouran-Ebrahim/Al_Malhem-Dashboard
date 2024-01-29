<?php


namespace Modules\HumanService\Service\ServiceType;

use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\HumanService\DTO\ServiceTypeDto;


use Illuminate\Support\Facades\DB;
use Modules\HumanService\Repository\ServiceType\ServiceTypeRepository;

class ServiceTypeService
{

    use ServiceTypeServiceHelper, UploaderHelper;

    protected $serviceTypeRepository;

    public function __construct()
    {
        $this->serviceTypeRepository = new ServiceTypeRepository();
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationCreate($data);
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new ServiceTypeDto($data))->dataFromRequest();



            $item = $this->serviceTypeRepository->create($data);
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

            $data = (new ServiceTypeDto($data))->dataFromRequest();

            $item = $this->serviceTypeRepository->update($data);

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

    public function all(array $data)
    {
        try {
            $items = $this->serviceTypeRepository->all($data);
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
    // public function active(array $data)
    // {
    //     try {
    //         $items = $this->serviceTypeRepository->active($data);
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
            $item = $this->serviceTypeRepository->find($id);
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

    public function delete($id)
    {
        // dd($id);
        try {
            $item = $this->serviceTypeRepository->find($id);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            // File::delete(public_path('uploads/news/' . $this->getImageName('news', $item->image)));
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
            $item = $this->serviceTypeRepository->find($id);
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
}
