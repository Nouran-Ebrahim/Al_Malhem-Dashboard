<?php

namespace Modules\ScientificExcellence\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Image;

class Party extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'file', 'date', 'is_active'];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function superiors()
    {
        return $this->hasMany(Superior::class, 'party_id');
    }
 
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
    
    public function getFileAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/Party/PDFs/' . $value);
        }
        return $value;
    }
}
