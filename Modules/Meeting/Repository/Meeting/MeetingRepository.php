<?php


namespace Modules\Meeting\Repository\Meeting;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;


use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Entities\Workinghour;

class MeetingRepository
{

    private $meetingModel;
    use UploaderHelper;

    public function __construct()
    {
        $this->meetingModel = new Meeting();
    }

    public function create(array $data)
    {
        // dd($data);
        $imageName = [];
        if (request()->hasFile('source')) {

            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Meetings');
            }
        }
        $meeting = $this->meetingModel->create($data);

        foreach ($data['workingHours'] as $workingHour) {

            Workinghour::create([
                'day_name' => $workingHour['day_name'],
                'from' => $workingHour['from'],
                'to' => $workingHour['to'],
                'meeting_id' => $meeting->id
            ]);
        }
        if ($meeting) {
            foreach ($imageName as $value) {
                $meeting->images()->create([
                    'source' => $value,
                ]);
            }
        }
        return $meeting->fresh();
    }

    public function update(array $data)
    {
        // dd($data['id']);
        $relation = ['client', 'images', 'workingHours'];
        $meeting = $this->meetingModel->with($relation)->find($data['id']);
        // dd($meeting);
        $meeting->update($data);

        if (request()->hasFile('source')) {

            $imageName = [];
            $images = request()->file('source');
            foreach ($images as $image) {
                $imageName[] = $this->upload($image, 'Meetings');
            }

            foreach ($imageName as $value) {
                $meeting->images()->create([
                    'source' => $value,
                ]);
            }
        }

        $ids = [];

        foreach ($meeting->workingHours as $workingHour) {
            $ids[] = $workingHour->id;
        }

        Workinghour::whereIn('id', $ids)->delete();

        foreach ($data['workingHours'] as $workingHour) {

            Workinghour::Create([
                'day_name' => $workingHour['day_name'],
                'from' => $workingHour['from'],
                'to' => $workingHour['to'],
                'meeting_id' => $data['id']
            ]);
        }


        return $meeting->fresh();
    }

    public function find($id, $relation = [])
    {
        return $this->meetingModel->whereId($id)->with($relation)->first();
    }

    public function findByIds($ids)
    {
        return $this->meetingModel->whereIn('id', $ids)->get();
    }

    public function delete($id)
    {

        $items = $this->meetingModel->where('id', $id)->delete();
    }

    public function all(array $data, $relation = [])
    {

        $meeting = $this->meetingModel->with($relation)
            ->when($data['client_id'] ?? null, function ($q) use ($data) {
                return $q->where('client_id', '=', $data['client_id']);
            })->when($data['is_active'] ?? null, function ($q) use ($data) {
                return $q->whereHas('client', function ($q) {
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
            )->latest();

        return getCaseCollection($meeting, $data);
    }

    // public function active(array $data, $relation = [])
    // {

    //     $meeting = $this->meetingModel->active()->with($relation)->when($data['meeting_category_id'] ?? null, function ($q) use ($data) {
    //         return $q->where('meeting_category_id', '=', $data['meeting_category_id']);
    //     });
    //     // dd($meeting->get());
    //     return getCaseCollection($meeting, $data);
    //     // return $meeting->get();
    // }
    // public function deleteImages($id)
    // {
    //     $images = Image::whereHasMorph(
    //         'imagetable',
    //         [Meetings::class],
    //         function ($query) use ($id) {

    //             $query->where('imagetable_id', $id);
    //         }
    //     );

    //     foreach ($images->get() as  $value) {

    //         File::delete(public_path('uploads/Meetings/' . $value->source));
    //     }
    //     // $images->delete();
    //     // Image::whereHasMorph(
    //     //     'imagetable',
    //     //     [Meetings::class],
    //     //     // or you can use * for all
    //     //     function ($query) use ($id) {
    //     //         $query->where('imagetable_id', $id);
    //     //     }
    //     // )->delete();
    // }
}
