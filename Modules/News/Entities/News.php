<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Image;
use Modules\News\Entities\NewsCategory;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'news_category_id','is_active'];

    protected $table = 'news';

    // protected static function newFactory()
    // {
    //     return \Modules\Common\Database\factories\NewsFactory::new();
    // }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->diffForHumans();
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function newsCategories()
    {
        return $this->belongsTo(NewsCategory::class, "news_category_id");
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }

}
