<?php

namespace App\Models;

use App\Traits\WithLogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasUuids, WithLogsActivity;
    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
