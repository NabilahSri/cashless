<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QRToken extends Model
{
    protected $table = 'qr_tokens';
    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
