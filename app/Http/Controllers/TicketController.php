<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Employee;
use App\User;
use App\Position;
use Illuminate\Http\Request;
use Auth;

class TicketController extends Controller
{
    
    public function index()
    {
        $wahana = Ticket::all();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('wahana.index', compact('wahana','authposition','authname'));
    }

    public function create()
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        $max = Ticket::max('wahana_id');
        $no_urut = (int) substr($max, 2, 2) + 1;
        $kode = "WS" .sprintf("%02s", $no_urut);

        
        return view ('wahana.create',compact('kode' ,'authposition','authname'));
    }

    public function store(Request $request)
    {
        $validasi = $request -> validate([
            'name'=> 'required',
            'price'=> 'required',
            'image'=> 'required',
       ]);

        if ($request->hasFile('image')){
            $file = $request ->file('image');
            $ext=$file->getClientOriginalExtension();
            $newName = $request->id."_gambar.".$ext;
            $file->move('image', $newName);
        }

       $wahana= Ticket::create([
            'wahana_id' => $request->id,
            'wahana_name' => $request->name,
            'price'  => $request->price,
            'image' => $newName,
       ]);

       return redirect()->route('wahana.index')->with('Status', 'data tiket berhasil ditambahkan!');
    }

    
    public function show($id)
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $wahana = Ticket::find($id);

        
        return view ('wahana.show',compact('authposition','authname', 'wahana'));
    }

   
    public function edit($tkt)
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $wahana = Ticket::where('wahana_id',$tkt)->first();


        return view ('/wahana.edit',compact('wahana','authposition','authname'));
    }

    
     
    public function update(Request $request, $tkt)
    {
        $wahana = Ticket::find($tkt);

        if ($request->hasFile('image')){
            $file = $request ->file('image');
            $ext=$file->getClientOriginalExtension();
            $newName = $request->id."_gambar.".$ext;
            $file->move('image', $newName);
        }

        $wahana->wahana_name = $request->name;
        $wahana->price = $request->price;
        $wahana->image = $newName;
        $wahana->save();


       return redirect()->route('wahana.index')->with('Status', 'data tiket berhasil diedit!');
    }

   
    public function destroy($id)
    {
        $wahana=Ticket::where('wahana_id','=',$id)->delete();
        return redirect()->route('wahana.index')->with('Status', 'data tiket berhasil dihapus!');
    }
}
