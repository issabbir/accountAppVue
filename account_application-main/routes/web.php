<?php

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get-projects', 'Admin\ProjectController@index');
Route::get('/view-project/{id}', 'Admin\ProjectController@show')->name('view-project');
Route::get('/edit-project/{id}', 'Admin\ProjectController@edit')->name('edit-project');
Route::post('/update-project', 'Admin\ProjectController@update')->name('update-project');
Route::post('/add-project', 'Admin\ProjectController@store')->name('add-project');
Route::get('/remove-project/{id}', 'Admin\ProjectController@destroy');
Route::post('/projects/remove-items', 'Admin\ProjectController@removeItems');

Route::get('/get-cvoucher', 'Admin\CreditVoucherController@index');
Route::get('/view-credit-voucher/{id}', 'Admin\CreditVoucherController@show')->name('view-credit-voucher');
Route::post('/add-cvoucher', 'Admin\CreditVoucherController@store')->name('add-cvoucher');

Route::get('/get-dvoucher', 'Admin\DebitVoucherController@index');
Route::get('/show-subhead', 'Admin\DebitVoucherController@subShow');
Route::get('/slip-info', 'Admin\DebitVoucherController@slipInfo');
Route::get('/view-debit-voucher/{id}', 'Admin\DebitVoucherController@show')->name('view-debit-voucher');
Route::get('/view-debit-voucher-history/{id}', 'Admin\DebitVoucherController@showHistory')->name('view-debit-voucher-history');
Route::get('/edit-debit-voucher/{id}', 'Admin\DebitVoucherController@edit')->name('edit-debit-voucher');
Route::post('/add-dvoucher', 'Admin\DebitVoucherController@store')->name('add-dvoucher');
Route::post('/update-dvoucher', 'Admin\DebitVoucherController@update')->name('update-dvoucher');

Route::get('/get-suppliers', 'Admin\SupplierController@index');
Route::post('/add-suppliers', 'Admin\SupplierController@store')->name('add-suppliers');
Route::post('/update-supplier', 'Admin\SupplierController@update')->name('update-supplier');
Route::get('/show-suppliers/{slug}', 'Admin\SupplierController@show')->name('show-suppliers');
Route::get('/remove-supplier/{slug}', 'Admin\SupplierController@destroy');

Route::get('/get-customers', 'Admin\CustomerController@index');
Route::post('/add-customers', 'Admin\CustomerController@store')->name('add-customers');
Route::get('/show-customers/{slug}', 'Admin\CustomerController@show')->name('show-customers');

Route::get('/get-products', 'Admin\ProductsController@index');

// Route::get('/get-products', 'Admin\ProductController@index');

Route::get('/get-client', 'Admin\ClientController@index');
Route::post('/add-clients', 'Admin\ClientController@store')->name('add-clients');
Route::get('/edit-client/{id}', 'Admin\ClientController@edit')->name('edit-client');
Route::post('/update-client', 'Admin\ClientController@update')->name('update-client');
Route::get('/remove-client/{id}', 'Admin\ClientController@destroy');
//Route::get('/view-credit-voucher/{id}', 'Admin\CreditVoucherController@show')->name('view-credit-voucher');

Route::get('/get-vendors', 'Admin\VendorController@index');
Route::post('/add-vendors', 'Admin\VendorController@store')->name('add-vendors');
Route::post('/update-vendor', 'Admin\VendorController@update')->name('update-vendor');
Route::get('/edit-vendor/{id}', 'Admin\VendorController@edit')->name('edit-vendor');
Route::get('/get-vendor-debit-amount/{id}', 'Admin\VendorController@show')->name('get-vendor-debit-amount');
//Route::get('/get-slip/{id}', 'Admin\VendorController@slips')->name('slips');
Route::get('/get-slips/{id}', 'Admin\SlipController@slips')->name('slips');
Route::get('/get-slip', 'Admin\SlipController@show')->name('slip');
Route::post('/store-slips', 'Admin\SlipController@store')->name('store-slips');

Route::get('/get-heads', 'Admin\HeadController@index');
Route::post('/add-heads', 'Admin\HeadController@store')->name('add-heads');
Route::get('/edit-head/{id}', 'Admin\HeadController@edit')->name('edit-head');
Route::post('/update-head', 'Admin\HeadController@update')->name('update-head');
Route::get('/remove-head/{id}', 'Admin\HeadController@destroy');
//Route::get('/view-credit-voucher/{id}', 'Admin\CreditVoucherController@show')->name('view-credit-voucher');

//Dashboard
Route::get('/debit-pie-chart', 'HomeController@debitedAmountPieChart');
Route::get('/credit-pie-chart', 'HomeController@creditedAmountPieChart');

