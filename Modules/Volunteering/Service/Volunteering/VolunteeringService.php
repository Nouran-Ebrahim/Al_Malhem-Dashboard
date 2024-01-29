<?php


namespace Modules\Volunteering\Service\Volunteering;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Admin\Service\AdminService;
use Modules\Common\Helper\UploaderHelper;
use Modules\Volunteering\DTO\VolunteeringDto;
use Modules\Volunteering\Repository\Volunteering\VolunteeringRepository;

class VolunteeringService
{

    use VolunteeringServiceHelper, UploaderHelper;

    protected $volunteeringRepository;

    public function __construct()
    {
        $this->volunteeringRepository = new VolunteeringRepository();
    }

    public function create($data)
    {
    //    dd($data->all());
    // $data=$data->all();
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationCreate($data->except('_token'));
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            // dd($validation);
             $data = (new VolunteeringDto($data))->dataFromRequest();

           
            // dd($validation);
            $item = $this->volunteeringRepository->create($data);

            DB::commit();
            return return_msg(true, 'Success', $item);

        } catch (\Exception $exception) {
            DB::rollBack();
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);

        }

    }

    public function update($data)
    {
        // dd($data->all());
        try {
            DB::beginTransaction();
            //validate Data
            $validation = $this->validationUpdate($data->except('_token'));
            if ($validation->fails()) {
                return return_msg(false, 'Validation Errors', [
                    'validation_errors' => $validation->getMessageBag()->getMessages(),
                ]);
            }
            $data = (new VolunteeringDto($data))->dataFromRequest();
            
            $item = $this->volunteeringRepository->update($data);
            DB::commit();

            return return_msg(true, 'Success', $item);
        } catch (\Exception $exception) {
            DB::rollBack();
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    public function all(array $data, $ralation = [])
    {
        try {
            $items = $this->volunteeringRepository->all($data, $ralation);
            return return_msg(true, 'Success', $items);
        } catch (\Exception $exception) {
            DB::rollBack();
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

 

    public function find($id, $relation = [])
    {
        try {
            $item = $this->volunteeringRepository->find($id, $relation);
            return return_msg($item ? true : false, 'Success', $item);
        } catch (\Exception $exception) {
            DB::rollBack();
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->volunteeringRepository->find($id);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }

            $item->delete();
            return return_msg(true, 'Success');
        } catch (\Exception $exception) {
            DB::rollBack();
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
            $item = $this->volunteeringRepository->find($id);
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
            return return_msg(false, 'Success', [
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }
}
