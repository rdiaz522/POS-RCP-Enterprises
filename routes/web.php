<?php

use App\Invoice;
use App\Sales;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('welcome');
});

Route::get('/index.php', function () {
    return view('welcome');
})->name('welcome');


Route::get('/home', function () {
    $weekMap = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];
    $dayOfTheWeek = Carbon::now()->dayOfWeek;
    $weekday = $weekMap[$dayOfTheWeek];
    $today = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
    $todayTwo = Carbon::today()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
    $sales = Sales::whereDate('created_at', '<=' , $today)->whereDate('created_at', '>=', $todayTwo)->orderBy('created_at', 'desc')->get();
    $invoice = Invoice::whereDate('created_at', Carbon::today())->where('status', 'printed')->get();
    return view('admin.index')->with(['sales' => $sales, 'weekday' => $weekday , 'invoice' => $invoice]);
    // dd($invoice);
})->middleware('checkuser')->name('home');

Route::post('/login', 'AuthController@login')->name('login');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::resource('/products', 'productController');
});

Route::get('/index.php/update', function () {
    return redirect()->route('products.index')->with('updated', 'Product has been updated!');
});
Route::get('/index.php/stockupdate', function () {
    return redirect()->route('inventory.index')->with('stockupdate', 'Stock has been updated!');
});

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::resource('/categories', 'categoryController');
});

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::resource('/supplier', 'supplierController');
});
Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::resource('/user', 'userController');
});

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::resource('/customer', 'customerController');
});

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function () {
    Route::get('/getSales', 'salesController@getSales');
    Route::get('/getMonthSales', 'salesController@getMonthSales');
    Route::post('/getWhatSales', 'salesController@getWhatSales')->name('getwhatsales');
    Route::resource('/sales', 'salesController');
});

Route::namespace('Cashier')->prefix('index.php')->middleware('checkCashier')->group(function () {
    Route::get('/getProducts', 'salesController@getProducts');
    Route::get('/invoice', 'salesController@invoice');
    Route::resource('/cashier', 'salesController');
    Route::resource('/setting', 'settingController');
});

Route::namespace('Cashier')->prefix('index.php')->middleware('checkCashier')->group(function () {
    Route::resource('/void', 'voidController');
});

Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function(){
    Route::post('/getWhatStock', 'stockController@getWhatStock')->name('getWhatStock');
    Route::resource('stock', 'stockController');
});


Route::namespace('Admin')->prefix('index.php')->middleware('checkuser')->group(function(){
    Route::put('/updatestock/{id}', 'inventoryController@updateStock');
    Route::post('/getStocker','inventoryController@getStocker')->name('getStocker');
    Route::resource('/inventory', 'inventoryController');
});

