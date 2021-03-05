<?php

namespace App\Http\Controllers\Admin;

use App\Stocks;
use App\Product;
use App\Category;
use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stocklogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
class productController extends Controller
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
        $barcode  = rand ( 100000000000 , 999999999999 );
        return view('admin.products')->with(['products' => $products, 'barcode' => $barcode, 'categories' => $categories, 'suppliers' => $suppliers]);
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
            'barcode' => 'required|numeric|unique:products,barcode',
            'name' => 'required|string|min:3',
            'brand' => 'nullable',  
            'price' => 'required',
            'profit' => 'required',
            'unit' => 'required',
            'net_wt' => 'nullable',
            'quantity' => 'required|numeric',
            'category' => 'nullable',
            'supplier' => 'nullable',
            'image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('image')) {
            $full_filename = $request->file('image')->getClientOriginalName();
            $name = pathinfo($full_filename, PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $name . '_' . time() . '.' . $ext;
            $storePath = $request->file('image')->storeAs('public/product_images', $filename);
        } else {
            $filename = 'no_image.png';
        }
        $products = new Product;
        $products->barcode = $request->barcode;
        $products->name = ucwords($request->name);
        $products->brand = ucwords($request->brand);
        $products->price = str_replace( ',', '', $request->price);
        $products->profit = str_replace( ',', '', $request->profit);
        $products->unit = ucwords($request->unit);
        if($request->net_wt == null){
            $products->net_wt = '';
        }else{
            $products->net_wt = $request->net_wt;
        }
        $products->category_id = $request->category;
        $products->supplier_id = $request->supplier;
        $products->status = $request->status;
        $products->image = $filename;
        $products->added_by = auth()->user()->username;
        $products->save();
        $product_id = $products->id;
        $stock = new Stocks;
        $stock->id = $product_id;
        $stock->quantity = $request->quantity;
        $stock->barcode = $request->barcode;
        $stock->save();
        return redirect()->route('products.index')->with('success', 'New Product Added!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(strlen($id) == 13 || strlen($id) == 12) {
            $setting = DB::table('settings')->get(); 
            $fullpath = $setting[0]->fullpaths;
            $connector = new WindowsPrintConnector($fullpath);
            $printer = new Printer($connector);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setBarcodeHeight(70);
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer -> barcode($id, Printer::BARCODE_JAN13);
            $printer -> feed(2);
            $printer -> cut();
            $printer -> close();
            return redirect()->back()->with('success','Print Successfully');
        }else if(strlen($id) >=4 && strlen($id) <= 6){
            $setting = DB::table('settings')->get(); 
            $fullpath = $setting[0]->fullpaths;
            $connector = new WindowsPrintConnector($fullpath);
            $printer = new Printer($connector);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setBarcodeHeight(70);
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer -> barcode($id, Printer::BARCODE_CODE39);
            $printer -> feed(2);
            $printer -> cut();
            $printer -> close();
            return redirect()->back()->with('success','Print Successfully');
        }else if(strlen($id) >= 6 && strlen($id) <= 8 || strlen($id) >= 11 && strlen($id) <= 12){
            $setting = DB::table('settings')->get(); 
            $fullpath = $setting[0]->fullpaths;
            $connector = new WindowsPrintConnector($fullpath);
            $printer = new Printer($connector);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setBarcodeHeight(70);
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer -> barcode($id, Printer::BARCODE_UPCA);
            $printer -> feed(2);
            $printer -> cut();
            $printer -> close();
            return redirect()->back()->with('success','Print Successfully');
        }else{
            return redirect()->back()->with('barcode_error','Barcode digit 9-10 & greater than 13 cannot be printed!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::with('categories', 'stocks')->find($id);
        return response()->json($products);
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
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|numeric|unique:products,barcode,' . $id,
            'name' => 'required|string|min:3',
            'brand' => 'nullable',
            'net_wt' => 'nullable',
            'unit' => 'required',
            'price' => 'required',
            'profit' => 'required',
            'category' => 'nullable',
            'supplier' => 'nullable',
            'image' => 'image|nullable|max:1999'
        ]);
        if ($request->ajax()) {
            if ($validator->passes()) {
                $products = Product::find($id);
                $products->barcode = $request->barcode;
                $products->name = ucwords($request->name);
                $products->brand = ucwords($request->brand);
                if($request->net_wt == null){
                    $products->net_wt = '';
                }else{
                    $products->net_wt = $request->net_wt;
                }
                $products->price = str_replace( ',', '', $request->price);
                $products->profit = str_replace( ',', '', $request->profit);
                $products->unit = ucwords($request->unit);
                if ($request->hasFile('image')) {
                    $full_filename = $request->file('image')->getClientOriginalName();
                    $name = pathinfo($full_filename, PATHINFO_FILENAME);
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $filename = $name . '_' . time() . '.' . $ext;
                    $storePath = $request->file('image')->storeAs('public/product_images', $filename);
                    $products->image = $filename;
                }
                $products->category_id = $request->category;
                $products->supplier_id = $request->supplier;
                $products->status = $request->status;
                $products->save();
                return 1;
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
        // return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->image !== 'no_image.png') {
            Storage::disk('public')->delete('product_images/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('deleted', 'Product has been deleted!');
    }
}
