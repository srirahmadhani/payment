<?php

namespace App\Http\Controllers;

use App\Topup;
use Illuminate\Http\Request;
use App\Visitor;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Auth;

class TopupController extends Controller
{
    public function index()
    {
        $topup = Topup::all();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('topup.index', compact('topup', 'authposition', 'authname'));
    }

    public function topupprint(Request $request)
    {
        $topup = Topup::where('topup_id', '=', $request->id)->first();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('topup.print', compact('topup', 'authposition', 'authname'));
    }

    
    public function create()
    {
        $max = Topup::max('topup_id');
        $no_urut = (int) substr($max, 9, 9) + 1;
        $kode = "TP" .sprintf("%09s", $no_urut);

        $visitor = Visitor::get();
        $employee = Employee::get();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('topup.create', compact('kode', 'visitor', 'employee', 'authposition', 'authname'));
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();

        $validasi = $request->validate([
            'visitor_id' => 'required'
            
        ]);

        $topup = Topup::create([
            'topup_id' => $request->id,
            'topup_date' => date(now()),
            'amount' => $request->amount,
            'id_visitor' => $request->visitor_id,
            'employee_id' => $request->pegawai
        ]);

        DB::commit();
        return redirect()->route('topup.index')->with('Status', 'Data Pegawai berhasil ditambahkan!');
    }

    
    public function destroy($id)
    {
        $employee = Topup::where('topup_id', '=', $id)->delete();
        return redirect()->route('topup.index')->with('Status', 'data topup berhasil dihapus!');
    }

    
}
