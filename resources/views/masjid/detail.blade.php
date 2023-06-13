@extends('layout.main')
@section('content')
<div class="grid grid-cols-5">
    <div class="col-span-2">
        <div id="image" class="mt-[20px]">
            <img src="{{ $masjid->foto }}" width="500px" alt="" class="mx-auto overflow-hidden max-h-[400px]">
            
            </div>
    </div>
    <div class="col-span-2">
        <div class="mt-4">
            
            <div class="mb-2">
                
                <i class="fa-solid fa-location-dot text-[2-px] text-[#175729D9] me-[5px]"></i>
                <span class="text-sm font-semibold text-[#175729D9]">{{ $masjid->alamat }}</span>
            </div>
            <h1 class="text-[45px] font-semibold">{{ $masjid->nama }} <sup><button onclick="share('http://masjidcare.test/masjid/{{ $masjid->id }}/detail')" class="text-3xl fa-solid fa-share"></button></sup></h1>
            <h2 class="text-[30px] mb-2 mt-4">Informasi Masjid</h2>
            <h3 class="">Luas: {{ round($masjid->luas) }} m<sup>3</sup></h3>
            <h3>Donasi Didapat: {{ "Rp " . number_format($total,2,',','.') }}</h3>
            <h2 class="text-[30px] mb-2 mt-4">Informasi Pengurus</h2>
            <h3>Nama: {{ $masjid->user->name }}</h3>
            <h3>Email: {{ $masjid->user->email }}</h3>
            <div class="flex items-center mt-6">
                <a href="/masjid/1/pembayaran" class="hover:no-underline me-2">
                    <div class="bg-[#175729] h-[50px] w-[150px] flex items-center rounded-[25px]" onclick="bayar()">
                        <span class="text-white text-2xl mx-auto">Donasi</span>
                    </div>
                </a>
                <a href="https:/wa.me/62{{ substr($masjid->user->phone, 1) }}" target="_blank" class="hover:no-underline">
                    <div class="flex items-center bg-[#25D366] text-slate-800 rounded-full h-[50px] w-[50px]">
                        <span class="mx-2.5"><i class="fa-brands fa-whatsapp me-2 text-4xl"></i></span>
                    </div>
                </a>
            </div>
        </div>
        
    </div>
  </div>
  <div>
    <h1 class="text-[30px] mb-4 mt-12 ms-6">Histori Penarikan</h1>
    <div class="grid grid-cols-4 gap-4 mx-4">
        @foreach($pencairan as $p)
          <div class="flex justify-center text-white items-center bg-[#38e232] p-4 rounded-[25px]">
            <span>{{ $p->tanggal }}</span>
            <span>Nominal: {{ "Rp " . number_format($p->nominal,2,',','.') }}</span>
          </div>
        @endforeach
      </div>
  </div>
  <div>
    <h1 class="text-[30px] mb-4 mt-12 ms-6">Histori Donasi</h1>
    <div class="grid grid-cols-4 gap-4 mx-4 mb-4">
        @foreach($donasi as $d)
          <div class="text-white bg-[#38e232] p-4 rounded-[25px]">
            <span>{{ $d->tanggal }}</span>
            <span>Nominal: {{ "Rp " . number_format($d->nominal,2,',','.') }}</span>
            <span>Donatur: {{ $d->user->name }}</span>
          </div>
        @endforeach
      </div>
  </div>
   
@endsection
@push('custom_js')
<script>
    function share(text){
        var input = document.createElement('input');
    input.setAttribute('value', text);
    document.body.appendChild(input);
    

    input.select();
    input.setSelectionRange(0, 99999); 
    document.execCommand('copy');
    

    document.body.removeChild(input);
    

    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Link Berhasil Disalin',
        showConfirmButton: false,
        timer: 1000
    })
    }
   </script>
@endpush