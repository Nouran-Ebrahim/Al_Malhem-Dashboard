<?php

namespace Modules\Volunteering\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Volunteering\Entities\VolunteeringRequest;

class Volunteering extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','is_active','name','gender','email','phone','details'];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function volunteeringTypes()
    {
        return $this->belongsToMany(VolunteeringType::class, 'volunteering_types_volunteerings', 'volunteering_id', 'volunteering_type_id','id','id')->withTimestamps();
    }
    public function volunteeringRequst()
    {
        return $this->belongsToMany(VolunteeringRequest::class, 'volunteering_req_volunteerings', 'volunteering_id', 'volunteering_request_id','id','id')->withTimestamps();
    }
}
