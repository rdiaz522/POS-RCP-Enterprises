<?php

namespace App\Http\Controllers\Cashier;

use App\Customer;
use App\CustomerInvoice;
use App\Sales;
use App\Stocks;
use App\Invoice;
use App\Product;
use App\Settings;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
class salesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $cashier = Auth::user()->username;
        $sales = Sales::whereDate('created_at', Carbon::today())->where('cashier',$cashier)->orderBy('created_at', 'desc')->get();
        $customers = Customer::all();
        $setting  = Settings::all();
        return view('cashier.index')->with(['sales' => $sales, 'customers' => $customers,'settings' => $setting]);
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

    public function getProducts()
    {
        $products = Product::with('categories', 'stocks', 'suppliers')->orderBy('id', 'desc')->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if ($request->ajax()) {
            if($request->cart){
                $carts = $request->cart;
                $change = $request->cash - $request->total;
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                $invoice = Invoice::all();
                $invCount = $invoice->count() + 1;
                $no =str_pad($invCount,7,"0",STR_PAD_LEFT );
                $invoice_no = $year . $month . $day . $no;
                $vatsales = 0;
                $vatexempt = 0;
                $vat = 0;
                foreach ($carts as $cart) {
                    if ($cart['status'] == 'V') {
                        $vatsales += floatval(str_replace(',', '', $cart['subtotal'])) / 1.12;
                        $vat += floatval(str_replace(',', '', $cart['subtotal'])) - round($vatsales, 2);
                    } else {
                        $vatexempt += floatval(str_replace(',', '', $cart['subtotal']));
                    }
                    $sales = new Sales;
                    $sales->name = $cart['name'];
                    $sales->net_wt = $cart['net_wt'];
                    $sales->unit = $cart['unit'];
                    $sales->price = $cart['price'];
                    $sales->profit = $cart['profit'];
                    $sales->quantity = $cart['quantity'];
                    $sales->subtotal = $cart['subtotal'];
                    $sales->vatable = $cart['status'];
                    $sales->invoice_number = $invoice_no;
                    $sales->cashier = Auth::user()->username;
                    $sales->barcode = $cart['barcode'];
                    $sales->discount = $cart['discount'];
                    $sales->save();
                    $stock = Stocks::find($cart['id']);
                    $stock->quantity = $stock->quantity - $cart['quantity'];
                    $stock->save();
                }
                $invoice = new Invoice;
                $invoice->invoice_number = $invoice_no;
                $invoice->cashier = Auth::user()->username;
                $invoice->item_qty = count($carts);
                $invoice->total = number_format($request->total, 2);
                $invoice->cash = number_format($request->cash, 2);
                $invoice->discount = $request->discount;
                $invoice->change = number_format($change, 2);
                $invoice->VAT_sales = number_format(round($vatsales, 2), 2);
                $invoice->VAT_exempt = number_format($vatexempt, 2);
                $invoice->VAT_zerorate = 0;
                $invoice->VAT = number_format($vat, 2);
                $invoice->save();

                if($request->customer){
                    $customer_invoice = new CustomerInvoice;
                    $customer_invoice->invoice_no = $invoice_no;
                    $customer_invoice->customer = $request->customer;
                    $customer_invoice->address = $request->customer_address;
                    $customer_invoice->business_style = $request->business_style;
                    $customer_invoice->save();
                }

                return response()->json($invoice_no);
            }else{
                return 0;
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
        
        $setting = DB::table('settings')->get(); 
        $fullpath = $setting[0]->fullpaths;
        if($id == 'noreciept'){
            return redirect()->back()->with('success','Transaction Successfully');
        }else{
            $inv_id = Invoice::where("invoice_number",$id)->first();
            if($inv_id){
                Invoice::where('invoice_number', $id)->update(array('status' => 'printed'));
                $items = Sales::where('invoice_number',$id)->get();
                $invoice = Invoice::where('invoice_number',$id)->get();
                $customer_inv = CustomerInvoice::where('invoice_no',$id)->first();
                $connector = new WindowsPrintConnector($fullpath);
                $printer = new Printer($connector);
    
                // /* Initialize */
                $printer -> initialize();
                $printer -> setFont(Printer::FONT_B);
                // /* Name of shop */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setTextSize(2,2);
                $printer -> text("ORDERING SLIP\n");
                $printer -> setTextSize(1,1);
                $printer -> text("$id\n");
                foreach($invoice as $invo){
                    $printer -> text($invo->created_at->format('m/d/Y h:i:s:A') . "\n");
                }
                $printer -> text("NON-VAT\n");
                $printer -> setFont(Printer::FONT_B);
                $printer -> setTextSize(1,1);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> setEmphasis(true);
                $printer -> selectPrintMode();
                $printer -> text('Sold to:');
                $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
                if($customer_inv !== null){
                    $printer -> text($customer_inv->customer. "\n");
                }else{
                    $printer -> text("_____________________\n");
                }
                $printer -> selectPrintMode();
                $printer -> text('Address:');
                $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
                if($customer_inv !== null){
                    $printer -> text($customer_inv->address ."\n");
                }else{
                    $printer -> text("_____________________\n");
                }
                $printer -> selectPrintMode();
                $printer -> text('Business Style:');
                $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
                if($customer_inv !== null){
                    $printer -> text($customer_inv->business_style ."\n");
                }else{
                    $printer -> text("_______________\n");
                }
               
                $printer -> selectPrintMode();
                $printer -> setEmphasis(false);
                $printer -> setEmphasis(true);
                $printer -> setJustification();
                $printer -> text("===============================\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text('Item'. '                  ');
                $printer -> text("Amount\n");
                $printer -> text("===============================\n");
                $printer -> setEmphasis(false);
                $printer -> pulse();
                /* Items */
                foreach($items as $item) {
                    $printer -> text(str_pad($item->name,30," "));
                    if($item->vatable == 'V'){
                        $printer -> text($item->vatable.''."\n");
                    }else{
                        $printer -> text("\n");
                    }
                    $printer -> text('Q:'.str_pad($item->quantity,4," ").' ');
                    $printer -> text('Net.W:'.str_pad($item->net_wt,8," ").' ');               
                    $printer -> text('P'. str_pad($item->subtotal,8," ").' ');
                    $printer -> text('Unit:'. $item->unit ."\n");
                    $printer -> setJustification();
                }
                $printer -> setEmphasis(true);
                $printer -> text("_______________________________\n");
                $printer -> setEmphasis(false);
                /* Tax and total */
                foreach($invoice as $invo){
                    $printer -> text('Total Amount' .'          P'.$invo->total. "\n");
                    $printer -> text('Discount  ' .'            -'.$invo->discount . "%\n");
                    $printer -> text('Cash      '.'            P'.$invo->cash. "\n");
                    $printer -> text('Change    ' .'            P'.$invo->change . "\n");
                    $printer -> selectPrintMode();
                    /* Footer */
                }
                $printer -> setEmphasis(true);
                $printer -> text("_______________________________\n");
                $printer -> setEmphasis(false);
                $printer -> feed(1);
                $printer -> text('Served By: '.ucwords(Auth::user()->username)."\n");
                /* Printer shutdown */
                $printer -> feed(1);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("ASK FOR YOUR OFFICIAL RECEIPT\n");
                $printer -> text("THIS DOCUMENT IS NOT\n");
                $printer -> text("VALID FOR CLAIM\n");
                $printer -> feed(1);
                $printer -> text("THANK YOU AND COME AGAIN!\n");
                $printer -> feed(3);
                $printer -> feedForm();
                $printer -> cut();
                $printer -> close();
                return redirect()->back()->with('success','Transaction Successfully');
            }else{
                return redirect()->back()->with('invoice_error','INVOICE NOT FOUND!');
            }
          
         
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
