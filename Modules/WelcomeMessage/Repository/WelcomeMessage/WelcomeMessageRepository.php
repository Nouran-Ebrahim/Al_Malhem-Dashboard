<?php


namespace Modules\WelcomeMessage\Repository\WelcomeMessage;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\WelcomeMessage\Entities\WelcomeMessage;

class WelcomeMessageRepository
{

    private $welcomeModel;
    use UploaderHelper;
    public function __construct()
    {
        $this->welcomeModel = new WelcomeMessage();
    }

    public function create(array $data)
    {
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = $this->upload($image, 'welcomeMessage');
            $data['image'] = $imageName;
        }
        $welcome = $this->welcomeModel->create($data);

        return $welcome->fresh();
    }

    public function update(array $data)
    {
        // dd($data);
        $welcome = $this->welcomeModel->find($data['id']);
        if (request()->hasFile('image')) {
            File::delete(public_path('uploads/welcomeMessage/' . $this->getImageName('welcomeMessage', $welcome->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'welcomeMessage');
            $data['image'] = $imageName;
        }
        $welcome->update($data);

        return $welcome->fresh();
    }

    public function find($id)
    {
        return $this->welcomeModel->whereId($id)->first();
    }
    public function findByIds($ids)
    {
        return $this->welcomeModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->welcomeModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {

        $welcome = $this->welcomeModel
            ->when($data['is_active'] ?? null, function ($q) use ($data) {
                return $q->active();
            })->when($data['lastMessages'] ?? null, function ($q) use ($data) {
                return $q->latest('created_at')->take($data['lastMessages']);
            });
        // dd($welcome->get())
        return getCaseCollection($welcome, $data);
    }
    public function active(array $data, $relation = [])
    {

        $welcome = $this->welcomeModel->active();
        // dd($welcome->get());
        return getCaseCollection($welcome, $data);
        // return $welcome->get();
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
