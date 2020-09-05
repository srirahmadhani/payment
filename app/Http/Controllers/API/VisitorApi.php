<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visitor;
use App\User;

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

        $this->validate($request, [
            'password' => ['required', 'min:8'],
            'email' => ['required', 'unique:users'],
        ]);

        $id_user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'level' => 2,
            'register_date' => date("Y-m-d H:i:s")
        ])->id;

        $validasi = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        $visitor = Visitor::create([
            'visitor_code' => $request->id,
            'visitor_name' => $request->name,
            'gender' => $request->gender, 'address' => $request->address,
            'visitor_id' => $id_user
        ]);

        DB::commit();

         
    }

   
}
