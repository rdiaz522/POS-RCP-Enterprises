<?php

namespace App\Http\View\Composer;

use App\Product;
use App\Stocks;
use Illuminate\View\View;

class NotificationComposer {
    public function compose(View $view){
        $outofstock = [];
        $stocks = Stocks::where('quantity','=',0)->get();
        foreach($stocks as $item) {
            $products = Product::where('id','=',$item->id)->get();
            foreach($products as $product){
                $data = ['name' => $product->name,'quantity' => $item->quantity];
                array_push($outofstock,$data);
            }   
        }

        $critical = [];
        $stock = Stocks::whereBetween('quantity',[1,10])->get();
        foreach($stock as $i) {
            $product = Product::where('id','=',$i->id)->get();
            foreach($product as $prod){
                $datas = ['name' => $prod->name,'quantity' => $i->quantity];
                array_push($critical,$datas);
            }   
        }
        
        $view->with(['critical' => $critical,'outofstock' => $outofstock]);
    }
}