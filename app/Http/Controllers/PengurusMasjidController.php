<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Masjid;
use App\Models\Pencairan;
use App\Models\PengurusMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PengurusMasjidController extends Controller
{
    public function postRegister(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'min:11', 'max:13', 'unique:users'],
            'name_masjid' => 'required',
            'alamat' => 'required|string|max:255',
            'luas' => 'required',
            'surat' => 'required|mimes:pdf',
            'foto' => 'required|mimes:jpeg,jpg,png,gif'
        ]);

        

        $foto_masjid = 'null';
        if($request->file('foto')){
            $foto_masjid = $request->file('foto')->store('foto_masjid', 'public');
        } 
        $surat_masjid = 'null';
        if($request->file('surat')){
            $surat_masjid = $request->file('surat')->store('surat_masjid', 'public');
        } 

        $masjid = new Masjid;
        $masjid->nama = $request->get('name_masjid');
        $masjid->alamat = $request->get('alamat');
        $masjid->luas = $request->get('luas');
        $masjid->surat = $surat_masjid;
        $masjid->foto = $foto_masjid;
        $masjid->request = 'pending';
        $masjid->save();
        $id = $masjid->id;
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'password_confirmation' => $request->password,
            'masjid_id' => $id
        ];
        return view('masjid.middle', [
            'data' => $data
        ]);

        
    }

    public function login(){
        return view('masjid.login');
    }

    public function validateLogin(){

    }

    public function index(){
        $donasi = Donasi::where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->get();
        $data_dicairkan = Pencairan::where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->get();
        $temp = 0;
        $dicairkan = 0;
        $saldo = Auth::user()->masjid->saldo;
        $jumlah_donasi = count($donasi);
        foreach($donasi as $donasi){
            $temp+= $donasi->nominal;
        }
        foreach($data_dicairkan as $data_dicairkan){
            $dicairkan += $data_dicairkan->nominal;
        }
        return view('pengurus.dashboard.index', [
            'title' => 'Dashboard',
            'link' => '/pengurus-dashboard',
            'total_donasi' => $this->formatAngka($temp),
            'dicairkan' => $this->formatAngka($dicairkan),
            'saldo' => $this->formatAngka($saldo),
            'jumlah_donasi' => $jumlah_donasi
        ]);
    }

    public function getDataDonasi(Request $request){
        if($request->start_date != '' && $request->end_date != ''){
            $donasi = Donasi::with('user')->where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->whereBetween('tanggal', [$request->start_date, $request->end_date])->paginate(12)->withQueryString();
        } else if($request->start_date != ''){
            $donasi = Donasi::with('user')->where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->where('tanggal', '>=', $request->start_date)->paginate(12)->withQueryString();
        } else if($request->end_date != ''){
            $donasi = Donasi::with('user')->where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->where('tanggal', '<=', $request->end_date)->paginate(12)->withQueryString();
          } else {
            $donasi = Donasi::with('user')->where('masjid_id', '=', Auth::user()->masjid->id)->where('status', '=', 'Approved')->paginate(12);
        }
        

        if(isset($request->start_date) || isset($request->end_date)){
            return view('pengurus.dashboard.donasi', [
            'title' => 'Data Donasi',
            'link' => '/pengurus-dashboard/data-donasi',
            'data' => $donasi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
            ]);
        } else {
            return view('pengurus.dashboard.donasi', [
                'title' => 'Data Donasi',
                'link' => '/pengurus-dashboard/data-donasi',
                'data' => $donasi
            ]); 
        }
    }

    public function getDataPencairanRequest(){
        $bank = ['BCA', 'BNI', 'Mandiri', 'BTN', 'BRI', 'BSI'];
        $pencairan = Pencairan::where('masjid_id', '=', Auth::user()->masjid->id)->get()->sortByDesc('tanggal');
        return view('pengurus.dashboard.pencairan', [
            'pencairan' => $pencairan,
            'title' => 'Pencairan',
            'link' => 'pengurus-dashboard/permintaan-pencairan',
            'bank' => $bank
        ]);
    }

    public function tarikDana(Request $request){
        $request->validate([
            'tarik' => 'required',
            'dokumen' => 'required|mimes:pdf',
        ]);
        $masjid = Auth::user()->masjid;
        if($request->get('tarik') > $masjid->saldo){
            return redirect()->back()->with('message', 'Saldo Tidak Cukup!');
        } else {
            $pencairan = new Pencairan;
            $pencairan->nominal = $request->get('tarik');
            $pencairan->tanggal = date('Y-m-d H:i:s');
            $pencairan->status = 'Pending';
            if($request->file('dokumen')){
                $dokumen = $request->file('dokumen')->store('pencairan_dana', 'public');
            } 
            if($request->get('bank')){
                $masjid->bank = $request->get('bank');
                $masjid->nomor_rekening = $request->get('norek');
            }
            $pencairan->pdf_laporan = $dokumen;
            $masjid->saldo -= $pencairan->nominal;
            $masjid->save();
            $pencairan->masjid()->associate($masjid);
            $pencairan->save();
            return redirect()->back();
        }
    }

    function formatAngka($angka) {
        $satuan = "";
        $formattedAngka = "";
      
        if ($angka >= 1000000000) {
          $formattedAngka = number_format($angka / 1000000000, 1);
          $satuan = "B";
        } elseif ($angka >= 1000000) {
          $formattedAngka = number_format($angka / 1000000, 1);
          $satuan = "M";
        } elseif ($angka >= 1000) {
          $formattedAngka = number_format($angka / 1000, 1);
          $satuan = "K";
        } else {
          $formattedAngka = number_format($angka, 1);
        }
      
        return $formattedAngka . $satuan;
      }
}
