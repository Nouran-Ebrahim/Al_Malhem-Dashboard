<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workinghour extends Model
{
    use HasFactory;

    protected $fillable = ['day_name', 'from','to','meeting_id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
