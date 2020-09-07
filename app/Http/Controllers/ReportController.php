<?php

namespace App\Http\Controllers;

use App\Topup;
use App\Payment;
use App\Employee;
use Illuminate\Http\Request;
use Auth;
use DB;

class ReportController extends Controller
{
    public function topupindex(Request $request)
    {
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        if ($request->type == 'search') {
            $topup = Topup::whereBetween(DB::raw('DATE(topup_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.topup_report', compact('topup', 'authposition', 'authname'));
        } elseif ($request->type == 'print') {
            $topup = Topup::whereBetween(DB::raw('DATE(topup_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.print', compact('topup', 'authposition', 'authname'));
        } else {
            $topup = Topup::get();
            return view('report.topup_report', compact('topup', 'authposition', 'authname'));
        }
    }

    public function paymentindex(Request $request)
    {
        $payment = Payment::all();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

         if ($request->type == 'search') {
            $payment = Payment::whereBetween(DB::raw('DATE(payment_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.payment_report', compact('payment', 'authposition', 'authname'));
        } elseif ($request->type == 'print') {
            $payment = Payment::whereBetween(DB::raw('DATE(payment_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.payment_print', compact('payment', 'authposition', 'authname'));
        } else {
            $payment = Payment::get();

          return view('report.payment_report', compact('payment', 'authposition', 'authname'));
    }
}

}