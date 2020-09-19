<?php

namespace App\Http\Controllers;

use App\Topup;
use App\Payment;
use App\Employee;
use Illuminate\Http\Request;
use Auth;
use DB;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function topupindex(Request $request)
    {
        $html_report = "";   
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        if ($request->type == 'search') {
            $topup = Topup::whereBetween(DB::raw('DATE(topup_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.topup_report', compact('topup', 'authposition', 'authname'));
        } elseif ($request->type == 'print') {
            $topup = Topup::whereBetween(DB::raw('DATE(topup_date)'), [$request->date_start, $request->date_end])->get();
            $html_report = view('report.print', compact('topup', 'authposition', 'authname'));
            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html_report);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream("laporan.pdf", array("Attachment" => false));
        } else {
            $topup = Topup::get();
            return view('report.topup_report', compact('topup', 'authposition', 'authname'));
        }

        
    }

    public function paymentindex(Request $request)
    {
        $html_report = "";

        $payment = Payment::all();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');

         if ($request->type == 'search') {
            $payment = Payment::whereBetween(DB::raw('DATE(payment_date)'), [$request->date_start, $request->date_end])->get();
            return view('report.payment_report', compact('payment', 'authposition', 'authname'));
        } elseif ($request->type == 'print') {
            $payment = Payment::whereBetween(DB::raw('DATE(payment_date)'), [$request->date_start, $request->date_end])->get();
            $html_report = view('report.payment_print', compact('payment', 'authposition', 'authname'))->render();
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html_report);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream("laporan.pdf", array("Attachment" => false));
        } else {
            $payment = Payment::get();

            return view('report.payment_report', compact('payment', 'authposition', 'authname'));
        }

        
        
}

}