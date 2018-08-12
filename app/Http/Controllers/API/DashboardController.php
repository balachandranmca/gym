<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubscriptionWillExpire()
    {
        $finalArray = \DB::select("SELECT t.id, t.customer_id, concat(c.fname,c.lname) name, c.regno, c.mobileno, c.email, t.subscription_id, r.MaxTime Subscription_Ends FROM ( SELECT customer_id, MAX(doe) as MaxTime FROM customer_subscriptions GROUP BY customer_id ) r INNER JOIN customer_subscriptions t ON t.customer_id = r.customer_id AND t.doe = r.MaxTime INNER JOIN customers c on t.customer_id = c.id where r.MaxTime < DATE_ADD(now(), INTERVAL 10 DAY)");

        $finalArray['count'] = count($finalArray);

        return $this->sendResponse($finalArray, '10 Days remaining to expire subscription list');
    }

    public function getSubscriptionExpired()
    {
        $finalArray = \DB::select("SELECT t.id, t.customer_id, concat(c.fname,c.lname) name, c.regno, c.mobileno, c.email, t.subscription_id, r.MaxTime Subscription_Ends FROM ( SELECT customer_id, MAX(doe) as MaxTime FROM customer_subscriptions GROUP BY customer_id ) r INNER JOIN customer_subscriptions t ON t.customer_id = r.customer_id AND t.doe = r.MaxTime INNER JOIN customers c on t.customer_id = c.id where r.MaxTime < now()");

        $finalArray['count'] = count($finalArray);

        return $this->sendResponse($finalArray, 'Expired subscription list');
    }

    public function getBirthDayRemainder()
    {
        $finalArray = \DB::select("SELECT * FROM customers WHERE DATE_ADD(dob, INTERVAL YEAR(CURDATE())-YEAR(dob) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(dob),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
        ");

        $finalArray['count'] = count($finalArray);

        return $this->sendResponse($finalArray, 'BirthDay list');
    }
    
}