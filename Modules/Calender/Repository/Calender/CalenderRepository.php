<?php


namespace Modules\Calender\Repository\Calender;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\Calender\Entities\NewsCalender;

class CalenderRepository
{

    private $newsModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->newsModel = new NewsCalender();
    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Calender');
            }
        }
        $calender = $this->newsModel->create($data);
        if ($calender) {
            foreach ($imageName as $value) {
                $calender->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $calender->fresh();
    }

    public function update(array $data)
    {
        $calender = $this->newsModel->find($data['id']);
        $calender->update($data);
        if (request()->hasFile('source')) {
            // $this->deleteImages($data['id']);
            // foreach ($calender->images as $value) {
            //     File::delete(public_path('uploads/Calender/' . $this->getImageName('Calender', $value->source)));
            // }
            // $calender->images()->delete();
            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Calender');
            }

            foreach ($imageName as $value) {
                $calender->images()->create([
                    'source' => $value,
                ]);
            }

        }


        return $calender->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->newsModel->whereId($id)->with($relation)->first();
    }
    public function findByIds($ids)
    {
        return $this->newsModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->newsModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {
// dd($data);
        $calender = $this->newsModel->with($relation)->when($data['date'] ?? null, function ($q) use ($data) {
            return $q->where('date', '=', $data['date']);
        })->when($data['is_active'] ?? null, function ($q) use ($data) {
            return $q->active();
        })->orderBy('date','desc');
        // dd($calender->get());
        return getCaseCollection($calender, $data);
        // return $calender->get();
    }

    public function dates()
    {
        return $this->newsModel->active()->select(DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as date'))->distinct()->pluck('date');
    }


}
