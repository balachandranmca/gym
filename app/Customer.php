<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $appends = array('customerSubscription', 'payment');

    public function customerSubscriptions()
    {
        return $this->hasMany('App\CustomerSubscription');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment');
    }

    public function getCustomerSubscriptionAttribute()
    {
        return $this->customerSubscriptions()->get();
    }

    public function getPaymentAttribute()
    {
        return $this->payment()->get();
    }
}
