<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
}
