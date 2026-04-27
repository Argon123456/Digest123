<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Digest extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'news' => 'json',
    ];
}
