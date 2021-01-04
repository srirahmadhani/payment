<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitor;
use App\Employee;
use App\Ticket;
use App\Transaction;
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
        $wahana     = Ticket::get();
        $transaction = new Transaction();
        $transactions_report = $transaction->reportTransactionsPerYear($year);

        $tiket = new Transaction();
        $tiket_report = $tiket->reportTransactionsPerYearDonat($yeard);

        $transactiontahun = Transaction::distinct()->select(DB::raw('YEAR(transaction_date) AS transaction_date'))->get();
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $jml_visitor = Visitor::all()->count();
        $jml_tiket = Ticket::all()->count();
        $total_transaction = DB::table('transactions')->sum('total');
         $saldo_total = DB::table('visitors')->sum('saldo');
        $visitor = new visitor();
        $total_saldo =$visitor->getVisitorSaldoTotal();

        return view('home', compact('visitor', 'employee', 'wahana', 'authposition', 'authname', 'transactions_report', 'transactiontahun', 'year', 'tiket_report', 'yeard', 'jml_visitor', 'jml_tiket', 'total_transaction', 'total_saldo','saldo_total'));


    }
}
