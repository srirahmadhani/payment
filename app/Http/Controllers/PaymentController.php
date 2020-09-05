<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Visitor;
use App\Ticket;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        
        $payment = Payment::all();

        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;

        return view('payment.index', compact('payment', 'authposition','authname'));

        // $payment = DB::table('payments')
        //             ->join('visitors','payments.visitor_id','=','visitors.visitor_id')
        //             ->join('tickets','payments.ticket_id','=','tickets.ticket_id')
        //             ->select('payments.*','visitors.*','tickets.*')
        //             ->get();
        // return view('payment.index', compact('payment'));

       
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max = Payment::max('payment_id');
        $no_urut = (int) substr($max, 9, 9) + 1;
        $kode = "TR" .sprintf("%09s", $no_urut);

        $visitor = Visitor::get();
        $ticket = Ticket::get();

        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;
        
        return view ('payment.create',compact('kode','visitor', 'ticket', 'authposition','authname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       DB::beginTransaction();

        $validasi = $request->validate([
            'visitor_id' => 'required'
            
        ]);


        // cek saldo visitor
        $saldo = Visitor::where("visitor_id", $request->visitor_id)->pluck('saldo')->first();

        if($saldo < $request->total)
        {
            return redirect()->route('payment.create')->with('Status', 'Saldo pengunjung tidak mencukupi!');
        }
        else
        {
            $payment = Payment::create([
                'payment_id' => $request->id,
                'payment_date' => date("Y-m-d H:i:s"),
                'qty'=>$request->qty,
                'total' =>$request->total,
                'visitor_id' => $request->visitor_id,
                'ticket_id' => $request->tiket
           ]);
           DB::commit();
           return redirect()->route('payment.index')->with('Status', 'Data Pegawai berhasil ditambahkan!');
           
        }


    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = DB::table('payments')
                ->join('visitors','visitors.visitor_id','=','payments.visitor_id')
                ->join('tickets','tickets.ticket_id','=','payments.ticket_id')
                ->select('payments.*','visitors.*','tickets.*')
                ->where('payments.payment_id','=', $id)
                ->first();


        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;

         return view ('payment.show',compact('payment', 'authposition','authname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $payment=Payment::where('payment_id','=',$id)->delete();
          return redirect()->route('payment.index')->with('Status', 'data payment berhasil dihapus!');
    }
}
