<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $guarded = [];
    protected $table = 'activity_log';

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }
}
