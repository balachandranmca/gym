<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    public function customerSubscriptions()
    {
        return $this->hasMany('App\CustomerSubscription');
    }
}
