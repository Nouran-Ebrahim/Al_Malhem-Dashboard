<?php

namespace Modules\Occasions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Image;
use Modules\Occasions\Entities\OccasionsCategory;

class Occasion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'occasions_category_id','date','is_active'];

    

    // protected static function newFactory()
    // {
    //     return \Modules\Common\Database\factories\NewsFactory::new();
    // }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function occasionsCategories()
    {
        return $this->belongsTo(OccasionsCategory::class, "occasions_category_id");
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
  
}
