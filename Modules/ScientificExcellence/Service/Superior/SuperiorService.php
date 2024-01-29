<?php


namespace Modules\ScientificExcellence\Service\Superior;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\ScientificExcellence\DTO\SuperiorDto;


use Illuminate\Support\Facades\DB;
use Modules\ScientificExcellence\Entities\Superior;
use Modules\ScientificExcellence\Repository\Superior\SuperiorRepository;

class SuperiorService
{

    use SuperiorServiceHelper, UploaderHelper;

    protected $superiorRepository;

    public function __construct()
    {
        $this->superiorRepository = new SuperiorRepository();
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
            // dd($this->getImageName('Superior', $data["certification"]));

            //  dd($data);
            $data = (new SuperiorDto($data))->dataFromRequest();
            // dd($data);
            $item = $this->superiorRepository->create($data);
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
            $data = (new SuperiorDto($data))->dataFromRequest();
            // dd($data);
            $item = $this->superiorRepository->update($data);
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
    public function addParty(array $data)
    {
        try {
            DB::beginTransaction();
            //validate Data
            // $validation = $this->validationUpdate($data);
            // if ($validation->fails()) {
            //     return return_msg(false, 'Validation Errors', [
            //         'validation_errors' => $validation->getMessageBag()->getMessages(),
            //     ]);
            // }
            // $data = (new SuperiorDto($data))->dataFromRequest();
            // dd($data);
            $item = $this->superiorRepository->addParty($data);
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
            $items = $this->superiorRepository->all($data, $relation);
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
    //         $items = $this->superiorRepository->active($data, $relation);
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
            $item = $this->superiorRepository->find($id);
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
            $item = $this->superiorRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }

            File::delete(public_path('uploads/Superior/Certification/' . $this->getImageName('Certification', $item->certification)));
            File::delete(public_path('uploads/Superior/Personal/' . $this->getImageName('Personal', $item->personal)));

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
            $item = $this->superiorRepository->find($id);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            $item->is_active = !$item->is_active;
            // $item->is_active = 0;

            // $item->party_id = null;

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
    function deleteSuperiorPhotos($id)
    {
        // dd($id);
        $SuperiorImage = Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/Superior/' . $this->getImageName('Superior', $SuperiorImage->source)));
        return $SuperiorImage->delete();
    }
}
