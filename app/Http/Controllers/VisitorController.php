<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\User;
use App\Transaction;
use App\Topup;
use App\Employee;
use App\Position;
use App\Helper\JwtHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class VisitorController extends Controller
{
    
    public function index()
    {
       
        $visitor = Visitor::all();
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('visitor.index', compact('visitor', 'authposition', 'authname'));
    }

    
    public function create()
    {
       
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('visitor.create', compact('authposition', 'authname'));
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();

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
            'visitor_name' => $request->name,
            'gender' => $request->gender, 'address' => $request->address,
            'visitor_id' => $id_user
        ]);

        DB::commit();
        return redirect()
            ->route('visitor.index')
            ->with('Status', 'data pengunjung berhasil ditambahkan!');
    }

   
   
    public function show($id)
    {

        $visitor = DB::table('visitors')
            ->join('users', 'visitors.visitor_id', '=', 'users.id')
            ->select('visitors.*', 'users.*')
            ->where('visitor_id', '=', $id)
            ->first();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        return view('visitor.show', compact('visitor', 'authposition', 'authname'));
    }

    
    public function edit($id)
    {
        $visitor = DB::table('visitors')
            ->join('users', 'visitors.visitor_id', '=', 'users.id')
            ->select('visitors.*', 'users.*')
            ->where('visitor_id', '=', $id)
            ->first();
        
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('/visitor.edit', compact('visitor', 'authposition', 'authname'));
    }

    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $visitor = Visitor::find($id);

        $visitor->visitor_id = $request->id;
        $visitor->visitor_name = $request->name;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->save();

        $user = User::find($visitor->visitor_id);

        $user->email = $request->email;

        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }

        $user->status = $request->status;

        $user->save();

        DB::commit();

        return redirect()
            ->route('visitor.index')
            ->with('Status', 'data pengunjung berhasil diedit!');
    }

    
    public function destroy($id)
    {
        $user = User::where('id', '=', $id)->delete();
        $visitor = Visitor::where('visitor_id', '=', $id)->delete();

        return redirect()
            ->route('visitor.index')
            ->with('Status', 'data pengunjung berhasil dihapus!');
    }


    public function cetakqrvisitor(Request $request, $id)
    {
        $data = array();
        $data['visitor'] = Visitor::find($id);
        $data['user'] = User::find($id);
        return view("visitor.cetakqr", $data);
    }

    public function aktivasiakun(Request $request, $token)
    {
        $data = JwtHelper::BacaToken($token);
        if(!$data['error'])
        {   
            // cek apakah tanggal aktivasi ditoken sudah kadaluarsa atau tidak
            if(strtotime($data['data']->batas_aktivasi) >= strtotime(date("Y-m-d H:i:s")))
            {
                // aktifkan akun
                $user = User::find($data['data']->id_user);
                $user->status = 1;
                $user->save();
            }
            else
            {
                $data['error'] = true;
            }
        }
        return view("visitor.aktivasi_akun", $data);
    }
}
