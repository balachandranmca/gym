<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSubscription extends Model
{
    //
    protected $appends = array('months');
    

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    public function getMonthsAttribute()
    {
        return $this->subscription()->first()->duration;
    }

}
