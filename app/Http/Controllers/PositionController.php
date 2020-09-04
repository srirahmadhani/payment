<?php

namespace App\Http\Controllers;

use App\Position;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $position = Position::all();

        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;

        return view('position.index', compact('position','authposition','authname'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max = Position::all();

        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;

        return view ('position.create',compact('max','authposition','authname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validasi = $request -> validate([
            'nama'=> 'required',
            
       ]);

       $position = Position::create([
            'position_id' => $request->id,
            'position_name' => $request->nama,
       ]);

       return redirect()->route('position.index')->with('Status', 'data jabatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);
        // $pengunjung=Pengunjung::where('id_pengunjung','=',$id)->first();

        $auth =Employee::where('employee_id','=', Auth::user()->id)->first();
        $authposition = $auth->id_position;
        $authname = $auth->employee_name;

        return view ('/position.edit',compact('position' ,'authposition','authname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $position = Position::find($id);
        
        $position->position_name = $request->nama;
        
        $position->save();



       return redirect()->route('position.index')->with('Status', 'data jabatan berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position=Position::where('position_id','=',$id)->delete();
        return redirect()->route('position.index')->with('Status', 'data jabatan berhasil dihapus!');
    }
}
