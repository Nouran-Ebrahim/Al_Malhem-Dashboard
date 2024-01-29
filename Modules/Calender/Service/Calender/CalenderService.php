<?php


namespace Modules\Calender\Service\Calender;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\Calender\DTO\CalenderDto;


use Illuminate\Support\Facades\DB;
use Modules\Calender\Entities\CalenderCalender;
use Modules\Calender\Repository\Calender\CalenderRepository;

class CalenderService
{

    use CalenderServiceHelper, UploaderHelper;

    protected $calenderRepository;

    public function __construct()
    {
        $this->calenderRepository = new CalenderRepository();
    }

    public function create(array $data)
    {
        //    dd($data);
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationCreate($data);
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new CalenderDto($data))->dataFromRequest();
// dd($data);

            $item = $this->calenderRepository->create($data);


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
            $data = (new CalenderDto($data))->dataFromRequest();

            $item = $this->calenderRepository->update($data);
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
            $items = $this->calenderRepository->all($data, $relation);
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
    public function dates()
    {
        try {
            $items = $this->calenderRepository->dates();
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
            $item = $this->calenderRepository->find($id);
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
            $item = $this->calenderRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            //    $this->calenderRepository->deleteImages($id);
            foreach ($item->images as $value) {
                File::delete(public_path('uploads/Calender/' . $this->getImageName('Calender', $value->source)));
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
            $item = $this->calenderRepository->find($id);
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

    function deleteCalenderPhotos($id)
    {
        // dd($id);
        $CalenderImage =  Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/Calender/' . $this->getImageName('Calender', $CalenderImage->source)));
        return $CalenderImage->delete();
    }
}
