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
    
    public function index() 
    {
        
        $payment = Payment::all();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('payment.index', compact('payment', 'authposition','authname'));
       
       
    }

    public function create()
    {
        $max = Payment::max('payment_id');
        $no_urut = (int) substr($max, 9, 9) + 1;
        $kode = "TR" .sprintf("%09s", $no_urut);

        $visitor = Visitor::get();
        $ticket = Ticket::get();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');
        
        return view ('payment.create',compact('kode','visitor', 'ticket', 'authposition','authname'));
    }

    
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
                'ticket_id' => $request->tiket,
                'employee_id' => $request->session()->get('id')
           ]);
           DB::commit();
           return redirect()->route('payment.index')->with('Status', 'Data Pegawai berhasil ditambahkan!');
           
        }


    }
    

    public function show($id)
    {
        $payment = DB::table('payments')
                ->join('visitors','visitors.visitor_id','=','payments.visitor_id')
                ->join('tickets','tickets.ticket_id','=','payments.ticket_id')
                ->select('payments.*','visitors.*','tickets.*')
                ->where('payments.payment_id','=', $id)
                ->first();


        $authposition = session()->get('id_position');
        $authname = session()->get('name');

         return view ('payment.show',compact('payment', 'authposition','authname'));
    }

   
   
    public function destroy($id)
    {
          $payment=Payment::where('payment_id','=',$id)->delete();
          return redirect()->route('payment.index')->with('Status', 'data payment berhasil dihapus!');
    }
}
