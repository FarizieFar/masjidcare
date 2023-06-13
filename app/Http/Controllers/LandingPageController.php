<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    
    public function index(){
        $masjid = Masjid::all()->sortBy('saldo')->take(8);
        
        foreach($masjid as $m){
            if(strlen($m->alamat) > 40){
                $m->alamat = substr($m->alamat, 1, 20) . '...' . substr($m->alamat, 40, 60);
            }
        }
        return view('landingpage.index')->with('masjid', $masjid);
    }
}
