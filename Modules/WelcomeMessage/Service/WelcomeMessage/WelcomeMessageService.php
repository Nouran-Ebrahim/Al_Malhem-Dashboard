<?php


namespace Modules\WelcomeMessage\Service\WelcomeMessage;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\WelcomeMessage\DTO\WelcomeMessageDto;


use Illuminate\Support\Facades\DB;
use Modules\WelcomeMessage\Repository\WelcomeMessage\WelcomeMessageRepository;

class WelcomeMessageService
{

    use WelcomeMessageServiceHelper, UploaderHelper;

    protected $exerciseRepository;

    public function __construct()
    {
        $this->exerciseRepository = new WelcomeMessageRepository();
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
            $data = (new WelcomeMessageDto($data))->dataFromRequest();


            $item = $this->exerciseRepository->create($data);


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
            // dd($data);
            $data = (new WelcomeMessageDto($data))->dataFromRequest();
            // dd($data);
            $item = $this->exerciseRepository->update($data);
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
            $items = $this->exerciseRepository->all($data, $relation);
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
    public function active(array $data, $relation = [])
    {
        try {
            $items = $this->exerciseRepository->active($data, $relation);
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

    public function find($id)
    {
        try {
            $item = $this->exerciseRepository->find($id);
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
            $item = $this->exerciseRepository->find($id);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            //    $this->exerciseRepository->deleteImages($id);
            File::delete(public_path('uploads/welcomeMessage/' . $this->getImageName('welcomeMessage', $item->image)));

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
            $item = $this->exerciseRepository->find($id);
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
