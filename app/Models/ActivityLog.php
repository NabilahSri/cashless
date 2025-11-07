<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $guarded = [];
    protected $table = 'activity_log';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'causer_id')->withTrashed();
    }
}
