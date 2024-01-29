<?php

namespace Modules\Volunteering\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Image;
use Modules\Volunteering\Entities\Volunteering;
use Modules\Volunteering\Entities\VolunteeringType;

class VolunteeringRequest extends Model
{
    use HasFactory;

   protected $fillable = ['title', 'description', 'date', 'is_active'];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function volunteeringTypes()
    {
        return $this->belongsToMany(VolunteeringType::class, 'volunteering_req_types', 'volunteering_request_id', 'volunteering_type_id','id','id')->withTimestamps();
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
    public function joines()
    {
        return $this->belongsToMany(Volunteering::class, 'volunteering_req_volunteerings','volunteering_request_id', 'volunteering_id','id','id')->withTimestamps();
    }
}
