<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberList extends Model
{
    protected $guarded = [];

    protected $table = 'subscriber_lists';

    public function subscribers()
    {
        //return $this->hasMany(\App\Subscriber::class,'subscriber_list_id','id');
        return $this->hasMany(\App\Subscriber::class,'subscriber_list_id','id');
    }
}
