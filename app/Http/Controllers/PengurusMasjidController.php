<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use App\Models\PengurusMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengurusMasjidController extends Controller
{
    public function postRegister(Request $request){
        // $request->validate([
        //     'name' => 'required|string|max:10',
        //     'email' => 'required|string|unique:masjids',
        //     'phone' => 'required|min:9|max:13|unique:masjids',
        //     'password' => 'required|string|min:8',
        //     'name_masjid' => 'required',
        //     'alamat' => 'required|string|max:255',
        //     'luas' => 'required',
        //     'surat' => 'required|mimes:pdf',
        //     'foto' => 'mimes:jpeg,jpg,png,gif'
        // ]);

        $foto_masjid = null;
        if($request->file('foto')){
            $foto_masjid = $request->file('foto')->store('foto_masjid', 'public');
        } 
        $surat_masjid = null;
        if($request->file('surat')){
            $surat_masjid = $request->file('surat')->store('surat_masjid', 'public');
        } 

        $pengurus = new PengurusMasjid;
        $pengurus->nama = $request->get('name');
        $pengurus->no_hp = $request->get('phone');
        $pengurus->email = $request->get('email');
        $pengurus->password = Hash::make($request->get('password'));

        $masjid = new Masjid;
        $masjid->nama = $request->get('name_masjid');
        $masjid->alamat = $request->get('alamat');
        $masjid->luas = $request->get('luas');
        $masjid->surat = $surat_masjid;
        $masjid->foto = $foto_masjid;
        $masjid->request = 0;
        $masjid->save();
        $id = $masjid->id;

        
        $pengurus->id_masjid = $id;
        $pengurus->save();
        $request->session();
        return redirect('/')
            ->with('success', 'masjid Berhasil Ditambahkan');
    }
}
