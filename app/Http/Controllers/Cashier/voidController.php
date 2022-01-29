<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Sales;
use App\Stocks;
use App\Voids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class voidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voids = Voids::all();
        return view('admin.voids')->with('voids', $voids);
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
        $voids = new Voids();
        $voids->name = $request->item_name;
        $voids->net_wt = $request->item_netwt;
        $voids->unit = $request->item_unit;
        $voids->price = $request->item_price;
        $voids->profit = $request->item_profit;
        $voids->quantity = (float)$request->item_quantity;
        $voids->subtotal = number_format((float)$request->item_quantity * (float)$request->item_price,2);
        $voids->cashier = $request->item_cashier;
        $voids->invoice_number = $request->item_inv;
        $voids->reason = $request->reason;
        $voids->status = $request->item_status;
        $voids->save();

        $sale = Sales::find($request->item_id);
        $newquant = (float)$sale->quantity - (float)$request->item_quantity;
        $newtotal = $newquant * (float)$request->item_price;

        if($request->item_status == 'Rejected'){
            if($sale->quantity == $request->item_quantity){
                $sale->delete();
                return redirect()->back()->with('voids', 'Successfully!');
            }else{
                $sale->quantity = $newquant;
                $sale->subtotal = number_format($newtotal,2);
                $sale->save();
                return redirect()->back()->with('voids', 'Successfully!');
            }
        }else{
            $stocks = Stocks::where('barcode',$request->item_barcode)->get();
            foreach ($stocks as $stock) {
                $stock->quantity = (float)$stock->quantity + (float)$request->item_quantity;
                $stock->save();
            }
            if($sale->quantity == $request->item_quantity){
                $sale->delete();
                return redirect()->back()->with('voids', 'Successfully!');
            }else{
                $sale->quantity = $newquant;
                $sale->subtotal = number_format($newtotal,2);
                $sale->save();
                return redirect()->back()->with('voids', 'Successfully!');
            }
        }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
