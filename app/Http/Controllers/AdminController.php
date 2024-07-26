<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Donasi;
use App\Models\Pencairan;

class AdminController extends Controller
{
    public function index(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        return view('admin.dashboard.index')->with('title', 'Home')->with('link', '/')
        ->with('masjid', $masjid);
    }

    public function pending(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        return view('admin.dashboard.pending',[
            'title' => 'Permintaan (Pending)',
            'masjid' => $masjid,
            'link' => '/admin-dashboard/pending'
        ]);
    }

    public function approve($id){
        $masjid = Masjid::find($id);
        $masjid->request = 'approved';
        $masjid->save();
        return redirect('/admin-dashboard/pending');
    }

    public function decline($id){
        $masjid = Masjid::find($id);
        $masjid->request = 'declined';
        $masjid->save();
        return redirect('/admin-dashboard/pending');
    }

    public function approved(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        return view('admin.dashboard.approved',[
            'title' => 'Permintaan (Approved)',
            'masjid' => $masjid,
            'link' => 'admin-dashboard/approved'
        ]);
    }

    public function declined(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        return view('admin.dashboard.declined',[
            'title' => 'Permintaan (Declined)',
            'masjid' => $masjid,
            'link' => 'admin-dashboard/declined'
        ]);
    }

    public function destroy(Request $request, $id){
        $masjid = Masjid::find($id);
        $user = User::where('masjid_id', '=', $id);
        $user->delete();
        $masjid->delete();
        return redirect($request->redirect_link);
    }

    public function getMasjid(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        $data = User::with('masjid')->get();
        return view('admin.dashboard.masjid', [
            'data' => $data,
            'masjid' => $masjid,
            'title' => 'Data Masjid',
            'link' => '/admin-dashboard/masjid'
        ]);
    }

    public function getDonatur(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        $data = User::where('level', '=', 'user')->get();
        return view('admin.dashboard.user', [
            'data' => $data,
            'masjid' => $masjid,
            'title' => 'Data Masjid',
            'link' => '/admin-dashboard/donatur'
        ]);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect('/admin-dashboard/donatur');
    }

    public function pencairan(){
        $pencairan = Pencairan::with('masjid')->where('status', 'Pending')->get();
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        return view('admin.dashboard.pencairan',[
            'pencairan' => $pencairan,
            'title' => 'Request Pencairan Dana',
            'link' => 'admin-dashboard/pencairan',
            'masjid' => $masjid
        ]);
    }

    public function terimaPencairan($id){
        $pencairan = Pencairan::with('masjid')->where('id', '=', $id)->first();
        $pencairan->status = 'Approved';
        $pencairan->masjid->saldo -= $pencairan->nominal;
        $pencairan->masjid->save();
        $pencairan->save();
        return redirect()->back();
    }

    public function tolakPencairan($id){
        $pencairan = Pencairan::find($id);
        $pencairan->status = 'Declined';
        $pencairan->save();
        return redirect()->back();
    }

    public function requestDonasi(){
        $masjid = User::where('level', '=', 'pengurus')->with('masjid')->get();
        $donasi = Donasi::with('user', 'masjid', 'metode')->where('isProcessed', '=', 'True')->where('status', '=','Pending')->get();
        foreach($donasi as $d){
            if(strlen($d->user->name) > 10){
                $d->user->nama = substr($d->user->nama, 0, 10) .'...';
            }
        }
        return view('admin.dashboard.donasi',[
            'donasi' => $donasi,
            'title' => 'Request Donasi',
            'link' => 'admin-dashboard/donasi',
            'masjid' => $masjid
        ]);
    }

    public function terimaDonasi($id, Request $request){
        $masjid_id = $request->get('masjid');
        $donasi = Donasi::find($id);
        $donasi->status = 'Approved';
        $masjid = Masjid::find($masjid_id);
        $masjid->saldo += $donasi->nominal;
        $masjid->save();
        $donasi->save();
        return redirect()->back();
    }

    public function tolakDonasi($id){
        $donasi = Donasi::find($id);
        $donasi->status = 'Declined';
        $donasi->save();
        return redirect()->back();
    }

    public function totalDonasi(){
        $masjidNotif = User::where('level', '=', 'pengurus')->with('masjid')->get();
        $masjid = Masjid::with('user')->where('request', '=', 'approved')->get();
        $donasi = Donasi::with('masjid')->where('status', '=', 'Approved')->get();
        $arrayTotalDonasi = [];
        foreach($donasi as $d){
            foreach($masjid as $m){
                if($m->id == $d->masjid->id){
                    if(isset($arrayTotalDonasi[$m->id])){
                        $arrayTotalDonasi[$m->id] += $d->nominal;
                    } else {
                        $arrayTotalDonasi[$m->id] = $d->nominal;
                    }
                    
                }
            }
        }
        $masjid = Masjid::with('user')->where('request', '=', 'approved')->paginate(10);
        return view('admin.dashboard.total_donasi', [
            'data' => $masjid,
            'total_donasi' => $arrayTotalDonasi,
            'title' => 'Data Donasi Masjid',
            'masjid'=> $masjidNotif,
            'link' => '/admin-dashboard/total-donasi',
        ]);
    }

}
