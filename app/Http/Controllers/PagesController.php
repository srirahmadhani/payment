<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function pembayaran()
    {
        return view('pembayaran.index');
    }


    public function topup()
    {
        return view('topup.index');
    }


    // public function pengunjung()
    // {
    //     return view('pengunjung.index');
    // }

    public function tiket()
    {
        return view('tiket.index');
    }


    public function pegawai()
    {
        return view('pegawai.index');
    }





}
