<?php

namespace Modules\Calender\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Image;

class NewsCalender extends Model
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

 
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
}
