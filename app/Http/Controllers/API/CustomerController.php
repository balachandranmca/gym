<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Customer;
use Validator;


class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully.');
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
            'fname' => 'required',
            'lname' => 'required',
            'mobileno' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $customer = new Customer;
        $customer->fname = $input['fname'];
        $customer->lname = $input['lname'];
        $customer->dob = $input['dob'];
        $customer->mobileno = $input['mobileno'];
        $customer->email = $input['email'];
        $customer->gender = $input['gender'];
        $customer->photo = $input['photo'];
        $customer->save();
        $customer->regno = date('Ym').($customer->id+10000);
        $customer->save();
        return $this->sendResponse($customer->toArray(), 'Customer created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }
        return $this->sendResponse($customer->toArray(), 'Customer retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'fname' => 'required',
            'lname' => 'required',
            'mobileno' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $customer->fname = $input['fname'];
        $customer->lname = $input['lname'];
        $customer->dob = $input['dob'];
        $customer->gender = $input['gender'];
        $customer->mobileno = $input['mobileno'];
        $customer->email = $input['email'];
        $customer->photo = $input['photo'];
        $customer->save();
        return $this->sendResponse($customer->toArray(), 'Customer updated successfully.');
    }

}