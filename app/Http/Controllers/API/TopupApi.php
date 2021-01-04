<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topup;
use App\Visitor;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Auth;

class TopupApi extends Controller
{
   public function index(Request $request, $id_visitor = null)
   {
        $topup = Topup::all();
        if($id_visitor != null)
        {
            $topup = Topup::where("id_visitor", $id_visitor)->get();
        }

        return response()->json(ResponseOk($topup));
   }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $max = Topup::max('topup_id');
        $no_urut = (int) substr($max, 9, 9) + 1;
        $kode = "TP" .sprintf("%09s", $no_urut);

        $topup = Topup::create([
            'topup_id' => $kode,
            'topup_date' => date(now()),
            'amount' => $request->amount,
            'id_visitor' => $request->id_visitor,
            'employee_nik' => $request->employee_nik
        ]);

        DB::commit();
        return response()->json(ResponseOk("Topup berhasil"));

    }

}
