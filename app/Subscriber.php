<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $guarded = [];

    protected $table = 'subscribers';

    public function subList()
    {
        //return $this->belongsTo(\App\SubscriberList::class,'subscriber_list_id');
        return $this->belongsTo(\App\SubscriberList::class);
    }
}
