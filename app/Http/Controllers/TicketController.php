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
        $ticket = Ticket::all();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('ticket.index', compact('ticket','authposition','authname'));
    }

    public function create()
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        $max = Ticket::max('ticket_id');
        $no_urut = (int) substr($max, 2, 2) + 1;
        $kode = "WS" .sprintf("%02s", $no_urut);

        
        return view ('ticket.create',compact('kode' ,'authposition','authname'));
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

       $ticket= Ticket::create([
            'ticket_id' => $request->id,
            'ticket_name' => $request->name,
            'price'  => $request->price,
            'image' => $newName,
       ]);

       return redirect()->route('ticket.index')->with('Status', 'data tiket berhasil ditambahkan!');
    }

    
    public function show($id)
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $ticket = Ticket::find($id);

        
        return view ('ticket.show',compact('authposition','authname', 'ticket'));
    }

   
    public function edit($tkt)
    {
        $authposition = session()->get('id_position');
        $authname = session()->get('name');


        $ticket = Ticket::where('ticket_id',$tkt)->first();


        return view ('/ticket.edit',compact('ticket','authposition','authname'));
    }

    
     
    public function update(Request $request, $tkt)
    {
        $ticket = Ticket::find($tkt);

        if ($request->hasFile('image')){
            $file = $request ->file('image');
            $ext=$file->getClientOriginalExtension();
            $newName = $request->id."_gambar.".$ext;
            $file->move('image', $newName);
        }

        $ticket->ticket_name = $request->name;
        $ticket->price = $request->price;
        $ticket->image = $newName;
        $ticket->save();


       return redirect()->route('ticket.index')->with('Status', 'data tiket berhasil diedit!');
    }

   
    public function destroy($id)
    {
        $ticket=Ticket::where('ticket_id','=',$id)->delete();
        return redirect()->route('ticket.index')->with('Status', 'data tiket berhasil dihapus!');
    }
}
