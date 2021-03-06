<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitor;
use App\Employee;
use App\Ticket;
use App\Payment;
use Auth;
use DB;

class HomeController extends Controller
{
    
    public function __construct()
    {
       
    }

    
    public function index(Request $request)
    {
        $year = date("Y");
        $yeard = date("Y");
        if ($request->has("year")) {
            $year = $request->input("year");
        } elseif ($request->has("yeard")) {
            $yeard = $request->input("yeard");
        }

        $visitor = Visitor::get();
        $employee   = Employee::get();
        $ticket     = Ticket::get();
        $payment = new Payment();
        $payments_report = $payment->reportPaymentsPerYear($year);

        $tiket = new Payment();
        $tiket_report = $tiket->reportPaymentsPerYearDonat($yeard);

        $paymenttahun = Payment::distinct()->select(DB::raw('YEAR(payment_date) AS payment_date'))->get();
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $jml_visitor = Visitor::all()->count();
        $jml_tiket = Ticket::all()->count();
        $total_payment = DB::table('payments')->sum('total');
         $saldo_total = DB::table('visitors')->sum('saldo');
        $visitor = new visitor();
        $total_saldo =$visitor->getVisitorSaldoTotal();

        return view('home', compact('visitor', 'employee', 'ticket', 'authposition', 'authname', 'payments_report', 'paymenttahun', 'year', 'tiket_report', 'yeard', 'jml_visitor', 'jml_tiket', 'total_payment', 'total_saldo','saldo_total'));


    }
}
