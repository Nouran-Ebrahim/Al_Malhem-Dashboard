<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Common\Entities\Image;
use Modules\Meeting\Entities\Workinghour;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', "title", "description", "lat", "long", "phone","client_id"];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function workingHours()
    {
        return $this->hasMany(Workinghour::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
}
