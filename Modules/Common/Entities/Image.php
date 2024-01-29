<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Calender\Entities\NewsCalender;
use Modules\HumanService\Entities\Service;
use Modules\Meeting\Entities\Meeting;
use Modules\News\Entities\News;
use Modules\Occasions\Entities\Occasion;
use Modules\ScientificExcellence\Entities\Party;
use Modules\ScientificExcellence\Entities\Superior;
use Modules\Volunteering\Entities\VolunteeringRequest;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['source'];

    // protected static function newFactory()
    // {
    //     return \Modules\Common\Database\factories\ImageFactory::new();
    // }
    public function imagetable()
    {
        return $this->morphTo();
    }

    public function getSourceAttribute($value)
    {
        if ($this->imagetable_type == News::class) {
            if ($value != null && $value != '') {
                return asset('uploads/News/' . $value);
            }
            return $value;
        } elseif ($this->imagetable_type == Occasion::class) {
            if ($value != null && $value != '') {
                return asset('uploads/Occasions/' . $value);
            }
            return $value;
        } elseif ($this->imagetable_type == Meeting::class) {
            if ($value != null && $value != '') {
                return asset('uploads/Meetings/' . $value);
            }
            return $value;
        }
        elseif ($this->imagetable_type == NewsCalender::class) {
            if ($value != null && $value != '') {
                return asset('uploads/Calender/' . $value);
            }
            return $value;
        } elseif ($this->imagetable_type == Service::class) {
            if ($value != null && $value != '') {
                return asset('uploads/Service/' . $value);
            }
            return $value;
        } elseif ($this->imagetable_type == Party::class) {
            if ($value != null && $value != '') {
                return asset('uploads/Party/' . $value);
            }
            return $value;
        }
        elseif ($this->imagetable_type == VolunteeringRequest::class) {
            if ($value != null && $value != '') {
                return asset('uploads/VolunteeringRequest/' . $value);
            }
            return $value;
        }

    }
}
