<?php

namespace App\Models;

use App\Traits\WithLogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasUuids, WithLogsActivity;
    protected $guarded = [];

    public function merchant()
    {
        return $this->hasMany(Merchant::class);
    }

    public function partnerUser()
    {
        return $this->hasMany(PartnerUser::class);
    }
}
