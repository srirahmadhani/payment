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
            $visitor = Visitor::where("visitor_id", $visitor_id)->first();
            $user = User::where("id", $visitor_id)->first();
            $data_visitor = array(
                "visitor_id"    => $visitor->visitor_id,
                "visitor_name"    => $visitor->visitor_name,
                "gender"    => $visitor->gender,
                "address"    => $visitor->address,
                "saldo"    => $visitor->saldo,
                "id"    => $visitor->id,
                "email"    => $user->email,
                "level"    => $user->level,
                "status"    => $user->status,
                "register_date"    => $user->register_date,
            );
            return response()->json(ResponseOk($data_visitor));
        }
        return response()->json(ResponseOk(Visitor::all()));
    }

    public function registrasi(Request $request)
    {
        DB::beginTransaction();

        if(User::where("email", $request->email)->exists())
        {
            return response()->json(ResponseError("Email tidak dapat digunakan karena sudah terdaftar!"));
        }

        $id_user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'level' => 2,
            'register_date' => date("Y-m-d H:i:s")
        ])->id;


        $visitor = Visitor::create([
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
        $user = User::find($visitor_id);
        if($user->email != $request->email && User::where("email", $request->email)->exists())
        {
            return response()->json(ResponseError("Email tidak dapat digunakan karena sudah terdaftar!"));
        }

        $user->email = $request->email;
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);       
        }

        $user->save();


        $visitor = Visitor::find($visitor_id);

        if(empty($visitor))
        {
            return response()->json(ResponseError("Profil tidak ditemukan"));
        }

        $visitor->visitor_name = $request->name;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->save();

        DB::commit();

        return response()->json(ResponseOk("Edit profil berhasil"));
    }
}
