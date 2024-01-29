<?php


namespace Modules\News\Service\News;

use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Illuminate\Support\Facades\File;
use Modules\News\DTO\NewsDto;


use Illuminate\Support\Facades\DB;
use Modules\News\Entities\News;
use Modules\News\Repository\News\NewsRepository;

class NewsService
{

    use NewsServiceHelper, UploaderHelper;

    protected $newsRepository;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
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
            $data = (new NewsDto($data))->dataFromRequest();
            
            
            $item = $this->newsRepository->create($data);
           

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
            $data = (new NewsDto($data))->dataFromRequest();

            $item = $this->newsRepository->update($data);
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
            $items = $this->newsRepository->all($data, $relation);
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
            $items = $this->newsRepository->active($data, $relation);
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
            $item = $this->newsRepository->find($id);
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
            $item = $this->newsRepository->find($id, $relation);
            if (!$item) {
                return return_msg(false, 'Success', [
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
        //    $this->newsRepository->deleteImages($id);
            foreach ($item->images as $value) {
                File::delete(public_path('uploads/News/' . $this->getImageName('News', $value->source)));
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
            $item = $this->newsRepository->find($id);
            if (!$item){
                return return_msg(false,'Success',[
                    'validation_errors' => [
                        'error_id' => ['Not Found'],
                    ],
                ]);
            }
            $item->is_active = !$item->is_active;
            $item->save();
            return return_msg(true,'Success');
        }catch (\Exception $exception){
            DB::rollBack();
            handleExceptionDD($exception);
            return return_msg(false,'Success',[
                'validation_errors' => [
                    'error_id' => [__('messages.server_error')],
                ],
            ]);
        }
    }

    function deleteNewsPhotos($id)
    {
        // dd($id);
        $NewsImage =  Image::where('id', $id)->firstorfail();
        File::delete(public_path('uploads/News/' . $this->getImageName('News', $NewsImage->source)));
        return $NewsImage->delete();
    }

}
