<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masjid;
use App\Models\PengurusMasjid;
use Illuminate\Support\Facades\Hash;

class MasjidController extends Controller
{
    
    public function register(){
        return view('masjid.forms');
    }
}
