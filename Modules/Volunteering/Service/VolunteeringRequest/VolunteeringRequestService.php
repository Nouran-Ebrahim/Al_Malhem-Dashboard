<?php


namespace Modules\Volunteering\Service\VolunteeringRequest;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\Volunteering\DTO\VolunteeringRequestDto;


use Illuminate\Support\Facades\DB;
use Modules\Volunteering\Entities\VolunteeringRequest;
use Modules\Volunteering\Repository\VolunteeringRequest\VolunteeringRequestRepository;

class VolunteeringRequestService
{

    use VolunteeringRequestServiceHelper, UploaderHelper;

    protected $volunteeringRequestRepository;

    public function __construct()
    {
        $this->volunteeringRequestRepository = new VolunteeringRequestRepository();
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
            $data = (new VolunteeringRequestDto($data))->dataFromRequest();



            $item = $this->volunteeringRequestRepository->create($data);
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

    public function join(array $data)
    {
        //  dd($data);
        try {
            DB::beginTransaction();
            //validate Data
            // $validation = $this->validationCreate($data);
            // if ($validation->fails()) {
            //     return return_msg(false, 'Validation Errors', [
            //         'validation_errors' => $validation->getMessageBag()->getMessages(),
            //     ]);
            // }
            // $data = (new VolunteeringRequestDto($data))->dataFromRequest();



            $item = $this->volunteeringRequestRepository->join($data);
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
            $data = (new VolunteeringRequestDto($data))->dataFromRequest();
            // dd($data);
            $item = $this->volunteeringRequestRepository->update($data);
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
            $items = $this->volunteeringRequestRepository->all($data, $relation);
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
    //         $items = $this->volunteeringRequestRepository->active($data, $relation);
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
            $item = $this->volunteeringRequestRepository->find($id);
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
            $item = $this->volunteeringRequestRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }

            foreach ($item->images as $value) {
                File::delete(public_path('uploads/VolunteeringRequest/' . $this->getImageName('VolunteeringRequest', $value->source)));
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
            $item = $this->volunteeringRequestRepository->find($id);
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
    function deleteVolunteeringRequestPhoto($id)
    {
        // dd($id);
        $VolunteeringRequestImage = Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/VolunteeringRequest/' . $this->getImageName('VolunteeringRequest', $VolunteeringRequestImage->source)));
        return $VolunteeringRequestImage->delete();
    }
}
