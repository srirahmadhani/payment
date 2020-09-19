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

                if($cek_email->level == 2)
                {
                    return redirect()->route('login')->with('Status', "Email atau assword salah!");
                }   

                if($cek_email->status == 0)
                {
                    return redirect()->route('login')->with('Status', "Akun Anda tidak aktif. Silahkan hubungi administrator!");
                }

                $detail = Employee::find($cek_email->id);

                if(!in_array($detail->id_position, array("KS1", "KS2", "KS3")))
                {
                    return redirect()->route('login')->with('Status', "Email atau assword salah!");
                }

                $name = $detail->employee_name;
                $nik = $detail->NIK;
                $employee_name = $detail->employee_name;
                $gender = $detail->gender;
                $phone = $detail->phone;
                $address = $detail->address;
                $id_position = $detail->id_position;

                $request->session()->put("id", $cek_email->id);
                $request->session()->put("email", $cek_email->email);
                $request->session()->put("level", $cek_email->level);
                $request->session()->put("name", $name);
                $request->session()->put("NIK", $nik);
                $request->session()->put("gender", $gender);
                $request->session()->put("phone", $phone);
                $request->session()->put("address", $address);
                $request->session()->put("id_position", $id_position);

                if($id_position == "KS3")
                {
                    return redirect()->route('topup.index')->with('Status', "Anda berhasil login!");
                }

                return redirect()->route('home')->with('Status', "Anda berhasil login!");

            }
            else
            {
                return redirect()->route('login')->with('Status', "Email atau assword salah!");
            }
        }
        else
        {   
            return redirect()->route('login')->with('Status', "Email salah!");
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget("id");
        $request->session()->forget("email");
        $request->session()->forget("level");
        $request->session()->forget("name");
        $request->session()->forget("NIK");
        $request->session()->forget("gender");
        $request->session()->forget("phone");
        $request->session()->forget("address");
        $request->session()->forget("id_position");

        return redirect("/");
    }
}
