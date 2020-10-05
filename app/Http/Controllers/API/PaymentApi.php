<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Visitor;
use App\Ticket;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Auth;


class PaymentApi extends Controller
{
 	public function index(Request $request, $id_visitor = null)
   {
        if($id_visitor != null)
        {
            $payment = Payment::select("*")->where("visitor_id", $id_visitor)->join("tickets", "tickets.ticket_id", "=", "payments.ticket_id")->get();
        }
        else
        {
            $payment = Payment::select("*")->join("tickets", "tickets.ticket_id", "=", "payments.ticket_id")->get();
        }

        return response()->json(ResponseOk($payment));
   }  

    public function store(Request $request)
    {
       DB::beginTransaction();

        $max = Payment::max('payment_id');
        $no_urut = (int) substr($max, 9, 9) + 1;
        $kode = "TR" .sprintf("%09s", $no_urut);

        // cek saldo visitor
        $saldo = Visitor::where("visitor_id", $request->visitor_id)->pluck('saldo')->first();

        if($saldo < $request->total)
        {
	        return response()->json(ResponseError('Saldo pengunjung tidak mencukupi!'));
        }
        else
        {
            $payment = Payment::create([
                'payment_id' => $kode,
                'payment_date' => date("Y-m-d H:i:s"),
                'qty'=>$request->qty,
                'total' =>$request->total,
                'visitor_id' => $request->visitor_id,
                'ticket_id' => $request->ticket_id,
                'employee_id' => $request->employee_id
           ]);
           DB::commit();
	       return response()->json(ResponseOk('Pembayaran berhasil!'));
        }


    }
}
