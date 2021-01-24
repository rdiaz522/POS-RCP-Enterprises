<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stocklogs;
use App\Stocks;
use Illuminate\Http\Request;

class stockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stocklogs::all();
        return view('admin.stock')->with('stocks', $stocks);
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

    public function getWhatStock(Request $request){
        $date_str = date_create($request->start);
        $start = date_format($date_str,"Y-m-d H:i:s");
        $date_end = date_create($request->end);
        $end = date_format($date_end,"Y-m-d H:i:s");
        $label = $request->label;
        $stocks = Stocklogs::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=',$end)
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.getstock')->with(['stocks' => $stocks, 'label' => $label]);
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
