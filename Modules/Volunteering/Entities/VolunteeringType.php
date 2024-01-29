<?php

namespace Modules\Volunteering\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VolunteeringType extends Model
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
    public function volunteering()
    {
        return $this->belongsToMany(Volunteering::class, 'volunteering_types_volunteerings', 'volunteering_type_id', 'volunteering_id','id','id')->withTimestamps();
    }
}
