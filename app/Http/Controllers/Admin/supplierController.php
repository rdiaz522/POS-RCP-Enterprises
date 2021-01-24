<?php

namespace App\Http\Controllers\Admin;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class supplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier')->with('suppliers',$suppliers);
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
            'name' => 'required|string|min:3|unique:suppliers,name',
            'address' => 'required',
            'contact_no' => 'required|numeric'
        ]);
        
        $supplier = new Supplier();
        $supplier->name = ucwords($request->name);
        $supplier->address = ucwords($request->address);
        $supplier->contact_no = $request->contact_no;
        $supplier->created_by = auth()->user()->username;
        $supplier->save();
        return redirect()->back()->with('success', 'New Supplier Added!');
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
        //
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
        $supplier = Supplier::find($id);
        $supplier->name = ucwords($request->namee);
        $supplier->address = ucwords($request->addresse);
        $supplier->contact_no = $request->contact_noe;
        $supplier->save();
        return redirect()->back()->with('updated','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }
}
