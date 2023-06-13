<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use App\Models\Masjid;
use App\Models\MetodePembayaran;
use App\Models\Nominal;
use App\Models\Pencairan;
use App\Models\PengurusMasjid;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MasjidController extends Controller
{
    
    public function register(){
        return view('masjid.forms');
    }

    public function index(Request $request){
        $query = '';
        $sort_by = null;

        if($request->get('q')){
            $query = $request->get('q');
            $masjid = Masjid::where('request', '=', 'Approved')->where('nama', 'like', "%$query%");
        } else {
            $masjid = Masjid::where('request', '=', 'Approved');
        }

        if($request->get('sort_by')){
            $sort_by = $request->get('sort_by');
            if($sort_by  === 'newest'){
                $masjid = $masjid->orderBy('created_at', 'desc');
            } else if ($sort_by === 'oldest'){
                $masjid = $masjid->orderBy('created_at', 'asc');
            } else if ($sort_by === 'luas_asc'){
                $masjid = $masjid->orderBy('luas', 'asc');
            } else if($sort_by === 'luas_desc'){
                $masjid = $masjid->orderBy('luas', 'desc');
            }
        }

        $masjid = $masjid->paginate(12)->withQueryString();
        
        
    

        foreach($masjid as $m){
            if(strlen($m->alamat) > 40){
                $m->alamat = substr($m->alamat, 1, 20) . '...' . substr($m->alamat, 40, 60);
            }
        }
        return view('masjid.index',[
            'q' => $query,
            'sort_by' => $sort_by,
            'masjid' => $masjid

        ]);
    }

    public function show($id){
        $masjid = Masjid::with('user')->find($id);
        $donasi = Donasi::with('user')->where('masjid_id', '=', $masjid->id)->get()->sortByDesc('tanggal');
        $pencairan = Pencairan::where('status', '=', 'Approved')->get()->sortByDesc('tanggal');

        $total_didapat = 0;
        foreach($donasi as $d){
            $total_didapat += $d->nominal;
        }
        $masjid = Masjid::find($id);
        return view('masjid.detail',[
            'masjid' => $masjid,
            'total' => $total_didapat,
            'pencairan' => $pencairan,
            'donasi' => $donasi
        ]);
    }

    public function pembayaran($id){
        $masjid = Masjid::find($id);
        $nominal = Nominal::all();
        $bank = MetodePembayaran::all();
        return view('masjid.pembayaran',[
            'masjid' => $masjid,
            'nominal' => $nominal,
            'bank' => $bank
        ]);
    }

    public function pengiriman($idPenerima, $idPengirim, Request $request){
        $add = [
            'nomor' => $request->get('nomor'),
            'bank' => $request->get('metode'),
            'anonim' => $request->get('anonim'),
            'nominal' => ($request->get('nominal') + mt_rand(0, 999))
        ];

        $donasi = new Donasi;
        $donasi->status = 'Pending';
        $donasi->isProcessed = 'False';
        $donasi->nominal = $add['nominal'];
        $donasi->tanggal = date('Y-m-d H:i:s');
        if($request->get('anonim') === 'Anonim'){
            $donasi->isAnonim = 'True';
        } else {
            $donasi->isAnonim = 'False';
        }
        $donasi->user_id = $idPengirim;
        $donasi->masjid_id = $idPenerima;
        $metode = MetodePembayaran::all();
        foreach($metode as $m){
            if($add['bank'] === $m->nama){
                $donasi->metode_id = $m->id;
            }
        }
        $donasi->save();
        return redirect("/pembayaran/$donasi->id");
    }

    public function metode($id){
        $donasi = Donasi::with('masjid', 'metode')->find($id);
        return view('user.pembayaran', [
            'donasi' => $donasi
        ]);
    }

    public function history(){
        $history = Donasi::with('masjid', 'user', 'metode')->where('user_id','=', Auth::user()->id)->get();
        return view('user.history',[
            'history' => $history
        ]);
    }

    public function transfer($id){
        $donasi = Donasi::find($id);
        $donasi->isProcessed = 'True';
        $donasi->save();
        return redirect('/history');
    }
}
