<?php

namespace App\Http\Controllers\Admin;

use App\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use Carbon\Carbon;
class salesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sales = Sales::whereDate('created_at', Carbon::today())->get();
        return view('admin.sales');
    }

    public function getSales()
    {
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        date_default_timezone_set('Asia/Manila');
        $sales = Sales::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at', 'ASC')->get();
        return response()->json($sales);
    }

    public function getMonthSales(){

        $months = Sales::where("created_at",">=", Carbon::now()->subMonths(6))->orderBy('created_at', 'desc')->get()->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('m');
        });
        return $months;
    }

    public function getWhatSales(Request $request){
        $date_str = date_create($request->start);
        $start = date_format($date_str,"Y-m-d H:i:s");
        $startLabel = date_format($date_str,"M-d-Y");
        $date_end = date_create($request->end);
        $end = date_format($date_end,"Y-m-d H:i:s");
        $endLabel =  date_format($date_end,"M-d-Y");
        $label = $request->label;
        $invoices = [];
        if($label == 'Today'){

            return redirect()->route('home');

        }else{
            $sales = Sales::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=',$end)
            ->orderBy('created_at','asc')
            ->get();
            $invoices = Invoice::whereDate('created_at', '>=',$start)
            ->whereDate('created_at', '<=',$end)
            ->where('status' , 'printed')
            ->get();
        }
            
       return view('admin.sales')->with(['sales' => $sales, 'label' => $label,'invoices' => $invoices,'startLabel' => $startLabel, 'endLabel' => $endLabel]);
 
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
