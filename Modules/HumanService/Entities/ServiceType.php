<?php

namespace Modules\HumanService\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanService\Entities\Service;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_active', 'color'];

    // protected static function newFactory()
    // {
    //     return \Modules\News\Database\factories\NewsCategoryFactory::new();
    // }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
