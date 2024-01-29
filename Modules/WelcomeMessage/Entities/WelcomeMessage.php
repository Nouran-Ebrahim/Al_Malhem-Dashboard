<?php

namespace Modules\WelcomeMessage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WelcomeMessage extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_active', 'image', 'description'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/welcomeMessage/' . $value);
        }
        return $value;
    }
}
