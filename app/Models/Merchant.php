<?php

namespace App\Models;

use App\Traits\WithLogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasUuids, WithLogsActivity;
    protected $guarded = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
