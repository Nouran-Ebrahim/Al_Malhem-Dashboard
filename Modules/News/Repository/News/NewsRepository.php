<?php


namespace Modules\News\Repository\News;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\News\Entities\News;

class NewsRepository
{

    private $newsModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->newsModel = new News();
    }

    public function create(array $data)
    {
        $imageName = [];
        if (request()->hasFile('source')) {
            $images = request()->file('source');

            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'News');
            }
        }
        $news = $this->newsModel->create($data);
        if ($news) {
            foreach ($imageName as $value) {
                $news->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $news->fresh();
    }

    public function update(array $data)
    {
        $news = $this->newsModel->find($data['id']);
        $news->update($data);
        if (request()->hasFile('source')) {
            // $this->deleteImages($data['id']);
            // foreach ($news->images as $value) {
            //     File::delete(public_path('uploads/News/' . $this->getImageName('News', $value->source)));
            // }
            // $news->images()->delete();
            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'News');
            }

            foreach ($imageName as $value) {
                $news->images()->create([
                    'source' => $value,
                ]);
            }
        }


        return $news->fresh();
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

        $news = $this->newsModel->with($relation)->when($data['news_category_id'] ?? null, function ($q) use ($data) {
            return $q->where('news_category_id', '=', $data['news_category_id']);
        })->when($data['is_active'] ?? null, function ($q) use ($data) {
            return $q->whereHas('newsCategories', function ($q) {
                $q->where('is_active', 1);
            })->active();
        })->when(
            $data['lastDaysCount'] ?? null,
            function ($q) use ($data) {

                return
                    $q->where(
                        'created_at',
                        '>=',
                        Carbon::now()->subDays($data['lastDaysCount'])->toDateTimeString()
                    );
            }
        )->orderBy('created_at', 'desc');
        // dd($news->get());
        return getCaseCollection($news, $data);
        // return $news->get();
    }
    public function active(array $data, $relation = [])
    {

        $news = $this->newsModel->active()->with($relation)->when($data['news_category_id'] ?? null, function ($q) use ($data) {
            return $q->where('news_category_id', '=', $data['news_category_id']);
        });
        // dd($news->get());
        return getCaseCollection($news, $data);
        // return $news->get();
    }
    // public function deleteImages($id)
    // {
    //     $images = Image::whereHasMorph(
    //         'imagetable',
    //         [News::class],
    //         function ($query) use ($id) {

    //             $query->where('imagetable_id', $id);
    //         }
    //     );

    //     foreach ($images->get() as  $value) {

    //         File::delete(public_path('uploads/News/' . $value->source));
    //     }
    //     // $images->delete();
    //     // Image::whereHasMorph(
    //     //     'imagetable',
    //     //     [News::class],
    //     //     // or you can use * for all
    //     //     function ($query) use ($id) {
    //     //         $query->where('imagetable_id', $id);
    //     //     }
    //     // )->delete();
    // }
}
