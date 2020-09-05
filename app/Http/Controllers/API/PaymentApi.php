<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;

class PaymentApi extends Controller
{
 	public function index(Request $request, $id_visitor = null)
   {
        $payment = Payment::all();
        if($id_visitor != null)
        {
            $payment = Payment::where("visitor_id", $id_visitor)->first();
        }

        return response()->json(ResponseOk($payment));
   }  
}
