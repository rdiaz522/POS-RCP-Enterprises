<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|string|min:3|unique:customers,fullname',
            'discount' => 'required'
        ]);

        $customers = new Customer();
        $customers->fullname = ucwords($request->fullname);
        $customers->contact_no = $request->contact_no;
        $customers->address = ucwords($request->address);
        $customers->discount = $request->discount;
        $customers->business_style = ucwords($request->business_style);
        $customers->save();
        return redirect()->back()->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => 'required|string|min:3|unique:customers,fullname,' . $id,
            'discount' => 'required'
        ]);

        $customers = Customer::find($id);
        $customers->fullname = ucwords($request->fullname);
        $customers->contact_no = $request->contact_no;
        $customers->address = ucwords($request->address);
        $customers->discount = $request->discount;
        $customers->business_style = ucwords($request->business_style);
        $customers->save();
        return redirect()->back()->with('updated', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customers = Customer::find($id);
        $customers->delete();
        return redirect()->back()->with('deleted', 'Successfully Deleted!');
    }
}
