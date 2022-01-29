<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Stocklogs;
use App\Stocks;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class inventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $products = Product::with('categories', 'stocks', 'suppliers')->orderBy('id', 'desc')->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $barcode  = rand();
        return view('admin.inventory')->with(['products' => $products, 'barcode' => $barcode, 'categories' => $categories, 'suppliers' => $suppliers]);

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
        //
    }

    public function updateStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric'
        ]);
        if ($request->ajax()) {

            if ($validator->passes()) {
                $stocks = Stocks::find($id);
                $stocks->quantity = $request->newstock;
                $stocks->save();

                $products = Product::find($id);
                $stocklogs = new Stocklogs;
                $stocklogs->item = $products->name;
                $stocklogs->net_wt = $products->net_wt;
                $stocklogs->unit = $products->unit;
                $stocklogs->brand = $products->brand;
                $stocklogs->oldstock = $request->old;
                $stocklogs->newstock = $request->newstock;
                $stocklogs->status = $request->stockstatus;
                $stocklogs->quantity = (float)$request->quantity;
                $stocklogs->description = $request->message_stock;
                $stocklogs->stock_by = auth()->user()->username;
                $stocklogs->save();
                return 1;
            }
        };
        return response()->json(['error' => $validator->errors()->all()]);

    }

    public function getStocker(Request $request) {
        if($request->stocker == 5){
            $products = Product::with(['stocks' => function($query) {
                $query->whereBetween('quantity',[1,10]);
            }])->get();
            $urlstatus = 'critical';
        }else if($request->stocker == 'all'){
            return redirect()->route('inventory.index');    
        }
        else {
            $products = Product::with(['stocks' => function($query) {
                $query->where('quantity','=', 0);
            }])->get();
            $urlstatus = 'outofstock';
        }
        $categories = Category::all();
        $suppliers = Supplier::all();
        $barcode  = rand();
        return view('admin.getStocker')->with(['products' => $products, 'barcode' => $barcode, 'categories' => $categories, 'suppliers' => $suppliers, 'urlstatus' => $urlstatus]);

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
