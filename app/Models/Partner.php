<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function merchant(){
        return $this->hasMany(Merchant::class);
    }

    public function partnerUser(){
        return $this->hasMany(PartnerUser::class);
    }
}
