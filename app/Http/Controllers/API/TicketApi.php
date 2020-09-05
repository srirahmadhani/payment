<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Employee;
use App\User;
use App\Position;

class TicketApi extends Controller
{
    public function index(Request $request, $ticket_id = null)
    {
    	if($ticket_id != null)
    	{
	        return response()->json(ResponseOk(Ticket::where("ticket_id", $ticket_id)->get()));
    	}
        return response()->json(ResponseOk(Ticket::all()));
    }
}
