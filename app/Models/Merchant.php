<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
