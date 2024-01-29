<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notification\Entities\Notification;
use Modules\Volunteering\Entities\Volunteering;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Order\Entities\History;
use Modules\Order\Entities\Order;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,LogsActivity;

    protected $fillable = ['name','phone','password','image','is_active','balance','verify_code','fcm_token'];
    protected $hidden =['password'];
    protected static $logName  = 'Client';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function scopeInActive($query)
    {
        return $query->where('is_active', 0);
    }
    public function histories()
    {
        return $this->morphMany(History::class, 'historible');
    }
     public function volunteering(){
        return $this->hasOne(Volunteering::class);
    }
    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/Client/' . $value);
        }
        return $value;
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orWhere('notifiable_id',null);
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
