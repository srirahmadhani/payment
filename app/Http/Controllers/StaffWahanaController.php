<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StaffWahana;
use App\Employee;
use App\Wahana;

class StaffWahanaController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date("Y-m-d"));
        $wahana_id = $request->input('wahana_id', "0");
        $wahana = Wahana::all();
        $employee = [];
        $jadwal = [];
        if($wahana_id != "0")
        {
            $jadwal = StaffWahana::with(["wahana", "employee"])->where("wahana_id", $wahana_id)->where("date", $date)->get();
            $employee = Employee::whereNotIn("employee_nik", StaffWahana::select("employee_nik")->where("date", $date)->get())->get();
        }
        else
        {
            $jadwal = StaffWahana::with(["wahana", "employee"])->where("date", $date)->get();
        }
        
        return view('staffwahana.index', compact("date", "wahana", "wahana_id", "employee", "jadwal"));
    }

    public function store(Request $request)
    {
        $max = StaffWahana::max('staff_wahana_id');
        if(empty($max))
        {
            $kode = "SW000001";
        }
        else
        {
            $no_urut = (int) str_replace("SW", "", $max) + 1;
            $kode = "SW" .str_pad($no_urut,6,"0", STR_PAD_LEFT);
        }

        StaffWahana::create([
            "staff_wahana_id" => $kode,
            "wahana_id" => $request->input("wahana_id"),
            "date" => $request->input("date"),
            "employee_nik" => $request->input("employee_nik")
        ]);

        return redirect("staff-wahana?date=".$request->input("date")."&wahana_id=".$request->input("wahana_id"));
    }

    public function delete(Request $request, $staff_wahana_id)
    {
        $date = $request->input("date", date("Y-m-d"));
        $wahana_id = $request->input("wahana_id", "0");
        StaffWahana::where('staff_wahana_id','=', $staff_wahana_id)->delete();
        return redirect("staff-wahana?date=".$date."&wahana_id=".$wahana_id);
    }
}
