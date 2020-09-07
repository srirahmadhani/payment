<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', "API\Autentikasi@cekLogin");
Route::get('/ticket/{ticket_id?}', "API\TicketApi@index");
Route::get('/topup/{id_visitor?}', "API\TopupApi@index");
Route::get('/payment/{id_visitor?}', "API\PaymentApi@index");
Route::get('/visitor/{visitor_id?}', "API\VisitorApi@index");
Route::post('/registrasi', "API\VisitorApi@registrasi");
Route::post('/edit-profil/{visitor_id?}', "API\VisitorApi@editProfil");

Route::post('/topup', "API\TopupApi@store");
Route::post('/payment', "API\PaymentApi@store");