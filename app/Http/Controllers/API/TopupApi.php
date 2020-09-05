<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topup;

class TopupApi extends Controller
{
   public function index(Request $request, $id_visitor = null)
   {
        $topup = Topup::all();
        if($id_visitor != null)
        {
            $topup = Topup::where("id_visitor", $id_visitor)->get();
        }

        return response()->json(ResponseOk($topup));
   }
}
