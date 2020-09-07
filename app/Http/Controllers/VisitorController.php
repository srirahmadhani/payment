<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\User;
use App\Payment;
use App\Topup;
use App\Employee;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitor = new Visitor();
        $visitor_data = $visitor->getVisitorWithSaldo();

        $payment = Payment::all();
        $topup = Topup::all();

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('visitor.index', compact('visitor_data', 'payment', 'topup', 'authposition', 'authname'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max = Visitor::max('visitor_code');
        $no_urut = (int)substr($max, 9, 9) + 1;
        $kode = "PG" . sprintf("%09s", $no_urut);

        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('visitor.create', compact('kode', 'authposition', 'authname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'visitor_code' => $request->id,
            'visitor_name' => $request->name,
            'gender' => $request->gender, 'address' => $request->address,
            'visitor_id' => $id_user
        ]);

        DB::commit();
        return redirect()
            ->route('visitor.index')
            ->with('Status', 'data pengunjung berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = DB::table('visitors')
            ->join('users', 'visitors.visitor_id', '=', 'users.id')
            ->select('visitors.*', 'users.*')
            ->where('visitor_id', '=', $id)
            ->first();
        // $pengunjung=Pengunjung::where('id_pengunjung','=',$id)->first();
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('/visitor.edit', compact('visitor', 'authposition', 'authname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
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
}
