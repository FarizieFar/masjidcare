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
        $masjid = Masjid::where('request', '=', 'Approved');
        if($request->get('q')){
            $query = $request->get('q');
            $masjid = $masjid->where('nama', 'like', "%$query%");
        } else {
            $masjid = $masjid->where('request', '=', 'Approved');
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
        $donasi = Donasi::with('user')->where('masjid_id', '=', $masjid->id)->where('status', '=', 'Approved')->get()->sortByDesc('tanggal');
        $pencairan = Pencairan::where('status', '=', 'Approved')->where('masjid_id', '=', $masjid->id)->get()->sortByDesc('tanggal');

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
        $donasi->snap_token = 'loading';
        $donasi->save();
        $id = $donasi->id;
        $donasi = Donasi::with('masjid', 'user')->where('id', $id)->first();
        \Midtrans\Config::$serverKey = config('midtrans.production_server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $params = array(
                'transaction_details' => array(
                'order_id' => $id,
                'gross_amount' => $donasi->nominal,
            ),
            'customer_details' => array(
                'first_name' => $donasi->user->name,
                'last_name' => '',
                'email' => $donasi->user->email,
                'phone' => $donasi->user->phone,
            ),
            );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $donasi->snap_token = $snapToken;
        $donasi->tenggat_waktu = now()->addHours(24);
        $donasi->save();
        
        return redirect("/pembayaran/$donasi->id");
    }

    public function metode($id){
        $donasi = Donasi::with('masjid', 'metode', 'user')->find($id);
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

    public function transfer(Request $request){
        $donasi = Donasi::find($request->order_id);
        $donasi->tenggat_waktu = $request->expiry_time;
        $donasi->save();
        $serverKey = config('midtrans.production_server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement'){
                $donasi = Donasi::find($request->order_id);
                $donasi->update(['status' => 'Approved', 'isProcessed' => 'True']);
            } 
        }
    }

    public function unfinish(Request $request){
        $donasi = Donasi::find($request->order_id);
        $donasi->tenggat_waktu = $request->expiry_time;
        $donasi->save();
    }
}
