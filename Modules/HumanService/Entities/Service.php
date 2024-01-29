<?php

namespace Modules\HumanService\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Common\Entities\Image;
use Modules\HumanService\Entities\ServiceType;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','service_type_id','description','type','is_active'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class , 'client_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
}
