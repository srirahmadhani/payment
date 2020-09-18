<?php

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
})->name('login');
Route::post('/login', 'Autentikasi@cekLogin')->name('cek_login');

// Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Autentikasi@logout')->name('logout');


//pengunjung

Route::resource('visitor', 'VisitorController');

//Tiket

Route::resource('ticket', 'TicketController');
Route::post('/ticket/{id}/update', 'ticketController@update')->name('ticket.update');

//jabatan
Route::resource('position', 'PositionController');

Route::post('/position/{id}/update', 'PositionController@update')->name('position.update');

//pegawai
Route::resource('employee', 'EmployeeController');

Route::post('/employee/{id}/update', 'EmployeeController@update')->name('employee.update');

//TopUp
Route::get('/topup/print', 'TopupController@topupprint')->name('topup.print');
Route::resource('topup', 'TopupController');
date_default_timezone_set("ASIA/JAKARTA");

//Payment
Route::resource('payment', 'PaymentController');



//Pembayaran
Route::resource('pembayaran', 'PembayaranController');

Route::get('/pembayaran', 'PembayaranController@index')->name('pembayaran.index');
Route::delete('/pembayaran/destroy/{id}', 'PembayaranController@destroy')->name('pembayaran.destroy');


Route::get('/user', 'UserController@user')->name('user');
Route::get('/user/create', 'UserController@usercreate')->name('usercreate');
Route::post('/user/create/add', 'UserController@usercreateadd')->name('usercreateadd');


//report
Route::get('/report/topup', 'ReportController@topupindex')->name('report.topup_report');

Route::get('/report/payment_report', 'ReportController@paymentindex')->name('report.payment_report');

Route::get('/visitor/cetak/qr/{id}', 'VisitorController@cetakqrvisitor')->name('visitor.cetakqr');
