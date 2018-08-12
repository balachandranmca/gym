<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Payment;
use App\CustomerSubscription;
use Validator;


class PaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerSubscriptions = Payment::all();

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
            'customer_subscription_id' => 'required',
            'customer_id' => 'required',
            'amount' => 'required',
            'paid_at' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());  
        }
        $customerSubscription = CustomerSubscription::find($input['customer_subscription_id']);
        if($customerSubscription->balance < $input['amount']){
            return $this->sendError('Error', "Balance amount error");    
        }  
        $payment = new Payment;
        $payment->customer_subscription_id = $input['customer_subscription_id'];
        $payment->customer_id = $input['customer_id'];
        $payment->amount = $input['amount'];
        $payment->paid_at = $input['paid_at'];
        $payment->save();
        $customerSubscription->balance = $customerSubscription->balance - $input['amount'];
        $customerSubscription->save();
        return $this->sendResponse($payment->toArray(), 'Payment created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        if (is_null($payment)) {
            return $this->sendError('Payment not found.');
        }
        return $this->sendResponse($payment->toArray(), 'Payment retrieved successfully.');
    }

}