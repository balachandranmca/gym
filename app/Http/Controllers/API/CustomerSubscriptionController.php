<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\CustomerSubscription;
use App\Subscription;
use Validator;


class CustomerSubscriptionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerSubscriptions = CustomerSubscription::all();

        return $this->sendResponse($customerSubscriptions->toArray(), 'Customers retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subscription_id' => 'required',
            'customer_id' => 'required',
            'amount' => 'required',
            'doj' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $balance_count = CustomerSubscription::where('customer_id',$input['customer_id'])->where('balance', '>', 0)->get()->count();

        if($balance_count > 0){
            return $this->sendError('Balance Error', 'CustomerSubscription Balance Error');  
        }
        $subscriptions = CustomerSubscription::where('customer_id',$input['customer_id'])->get();

        $doj = $input['doj'];
        foreach($subscriptions as $subscription){
            $startDate = $subscription->doj;
            $toDate = $subscription->doe;
            // $months = $subscription->months; 
            // $addedMonths = "+".$months." months";
            // $toDate = date('Y-m-d', strtotime($addedMonths, strtotime($startDate)));

            if (($doj >= $startDate) && ($doj <= $toDate)){
                return $this->sendError('Date Error', "Subscription Date Already available between $startDate and $toDate");
            }
        }
        $month = Subscription::find($input['subscription_id'])->duration;
        $addedMonths = "+".$month." months";
        $toDate = date('Y-m-d', strtotime($addedMonths, strtotime($input['doj'])));

        $customerSubscription = new CustomerSubscription;
        $customerSubscription->subscription_id = $input['subscription_id'];
        $customerSubscription->customer_id = $input['customer_id'];
        $customerSubscription->amount = $input['amount'];
        $customerSubscription->doj = $input['doj'];
        $customerSubscription->doe = $toDate;
        $customerSubscription->balance = $input['amount'];
        $customerSubscription->save();
        return $this->sendResponse($customerSubscription->toArray(), 'CustomerSubscription created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customerSubscription = CustomerSubscription::find($id);
        if (is_null($customerSubscription)) {
            return $this->sendError('CustomerSubscription not found.');
        }
        return $this->sendResponse($customerSubscription->toArray(), 'CustomerSubscription retrieved successfully.');
    }

}