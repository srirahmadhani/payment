<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Visitor;
use App\Employee;
use App\User;

class Autentikasi extends Controller
{
    public function cekLogin(Request $request)
    {
        $data_login = $request->all();

        $cek_email = User::where("email", $data_login['email'])->first();
        if(!empty($cek_email))
        {
            $cek_password = Hash::check($data_login['password'], $cek_email->password);
            if($cek_password)
            {
                if($cek_email->level == 1) // pegawai
                {
                    $detail = Employee::find($cek_email->id);
                    $name = $detail->employee_name;
                    $code = $detail->NIK;
                }
                else // pengunjung
                {
                    $detail = Visitor::find($cek_email->id);
                    $name = $detail->visitor_name;
                    $code = $detail->visitor_code;
                }

                $request->session()->put("id", $cek_email->id);
                $request->session()->put("email", $cek_email->email);
                $request->session()->put("level", $cek_email->level);
                $request->session()->put("name", $cek_email->name);
                $request->session()->put("code", $cek_email->code);
                return redirect()->route('home')->with('Status', "Anda berhasil login!");
                
            }
            else
            {
                return redirect()->route('login')->with('Status', "Username atau password salah!");
            }
        }
        else
        {   
            return redirect()->route('login')->with('Status', "Username atau password salah!");
        }
    }
}
