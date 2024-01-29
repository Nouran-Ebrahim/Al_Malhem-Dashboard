<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Notification\Entities\Notification;
use Modules\Order\Entities\History;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory,HasRoles,CausesActivity,LogsActivity;

    protected $fillable = ['name','email','phone','image','password','is_active','school_id'];
    protected $hidden =['password'];
    protected static $logName  = 'Admin';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function histories()
    {
        return $this->morphMany(History::class, 'historible');
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
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
    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/admin/' . $value);
        }
        return $value;
    }
}
