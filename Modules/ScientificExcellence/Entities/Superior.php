<?php

namespace Modules\ScientificExcellence\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Common\Entities\Image;

class Superior extends Model
{
    use HasFactory;

    protected $fillable = ['name','certification','personal','gender','civil','year','specialization','gpa',"phone",'parent_phone','is_active','party_id'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
    // public function client()
    // {
    //     return $this->belongsTo(Client::class, 'client_id');
    // }

    public function getCertificationAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/Superior/Certification/' . $value);
        }
        return $value;
    }
    public function getPersonalAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/Superior/Personal/' . $value);
        }
        return $value;
    }
}
