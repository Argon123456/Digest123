<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    protected $guarded = [];

    public function digestType()
    {
        return $this->belongsTo(\App\DigestType::class);
    }
}
