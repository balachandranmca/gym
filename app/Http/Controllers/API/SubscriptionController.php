<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Subscription;
use Validator;


class SubscriptionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::all();

        return $this->sendResponse($subscriptions->toArray(), 'Subscriptions retrieved successfully.');
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
            'name' => 'required',
            'amount' => 'required',
            'duration' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $subscription = new Subscription;
        $subscription->name = $input['name'];
        $subscription->amount = $input['amount'];
        $subscription->duration = $input['duration'];
        $subscription->save();
        return $this->sendResponse($subscription->toArray(), 'Subscription created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);
        if (is_null($subscription)) {
            return $this->sendError('Subscription not found.');
        }
        return $this->sendResponse($subscription->toArray(), 'Subscription retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'amount' => 'required',
            'is_active' => 'required',
            'duration' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $subscription->name = $input['name'];
        $subscription->amount = $input['amount'];
        $subscription->is_active = $input['is_active'];
        $subscription->duration = $input['duration'];
        $subscription->save();
        return $this->sendResponse($subscription->toArray(), 'Subscription updated successfully.');
    }

}