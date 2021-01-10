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

Route::resource('wahana', 'WahanaController');
Route::post('/wahana/{id}/update', 'wahanaController@update')->name('wahana.update');

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

//Transaction
Route::resource('transaction', 'TransactionController');



//Pembayaran
Route::resource('pembayaran', 'PembayaranController');

Route::get('/pembayaran', 'PembayaranController@index')->name('pembayaran.index');
Route::delete('/pembayaran/destroy/{id}', 'PembayaranController@destroy')->name('pembayaran.destroy');


Route::get('/user', 'UserController@user')->name('user');
Route::get('/user/create', 'UserController@usercreate')->name('usercreate');
Route::post('/user/create/add', 'UserController@usercreateadd')->name('usercreateadd');


//report
Route::get('/report/topup', 'ReportController@history_topupindex')->name('report.topup_report');

Route::get('/report/transaction_report', 'ReportController@transactionindex')->name('report.transaction_report');

Route::get('/visitor/cetak/qr/{id}', 'VisitorController@cetakqrvisitor')->name('visitor.cetakqr');


Route::get('/akun/aktivasi/{token}', 'VisitorController@aktivasiakun')->name('akun.aktivasi');

Route::get('/staff-wahana', 'StaffWahanaController@index')->name('staffwahana.index');
Route::post('/staff-wahana', 'StaffWahanaController@store')->name('staffwahana.store');
Route::get('/staff-wahana/hapus/{employee_nik}', 'StaffWahanaController@delete')->name('staffwahana.delete');
