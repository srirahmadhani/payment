<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visitor;
use App\User;
use App\Payment;
use App\Topup;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class VisitorApi extends Controller
{
    public function index(Request $request, $visitor_id = null)
    {
        if($visitor_id != null)
        {
            return response()->json(ResponseOk(Visitor::where("visitor_id", $visitor_id)->first()));
        }
        return response()->json(ResponseOk(Visitor::all()));
    }

    public function registrasi(Request $request)
    {
       DB::beginTransaction();

        $max = Visitor::max('visitor_code');
        $no_urut = (int)substr($max, 9, 9) + 1;
        $kode = "PG" . sprintf("%09s", $no_urut);

        $id_user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'level' => 2,
            'register_date' => date("Y-m-d H:i:s")
        ])->id;


        $visitor = Visitor::create([
            'visitor_code' => $kode,
            'visitor_name' => $request->name,
            'gender' => $request->gender,
            'address' => $request->address,
            'visitor_id' => $id_user
        ]);

        DB::commit();
        return response()->json(ResponseOk("Registrasi berhasil"));

         
    }


    public function editprofil(Request $request, $visitor_id = null)
    {
        DB::beginTransaction();
        $visitor = Visitor::find($visitor_id);

        if(empty($visitor))
        {
            return response()->json(ResponseError("Profil tidak ditemukan"));
        }

        $visitor->visitor_name = $request->name;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->save();

        $user = User::find($visitor_id);

        $user->email = $request->email;
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);       
        }

        $user->save();

        DB::commit();

        return response()->json(ResponseOk("Edit profil berhasil"));
    }
}
