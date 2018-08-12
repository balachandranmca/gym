<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    public function customersubscription()
    {
        return $this->belongsTo('App\CustomerSubscription');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
