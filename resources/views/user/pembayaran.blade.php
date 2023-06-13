@extends('layout.main')
@section('content')
<div class="flex items-center my-10">
    <div class="w-[500px] h-[400px] mx-auto rounded-[50px] border-4 text-[#175729]">
        <h1 class="mt-4 font-semibold text-2xl text-center mb-4">Pembayaran</h1>
        <div class="ms-6">
            <h3 class="text-xl mb-2">Metode Pembayaran: Bank {{ $donasi->metode->nama }}</h3>
        <h3 class="text-xl mb-2">Nomor Rekening: {{$donasi->metode->nomor }}</h3>
        <h3 class="text-xl mb-2">Masjid Tujuan: {{$donasi->masjid->nama }}</h3>
        <h1 class="text-xl">Nominal: {{ "Rp. " . number_format($donasi->nominal,2,',','.') }}</h1>

        <span class="text-red-500 text-base mb-16">Keterangan: Mohon pembayaran dilakukan secepatnya</span>
        
        
        </div>
        <div class="text-center mt-24">
            <form action="/sudah-transfer/{{ $donasi->id }}" method="post">
                @csrf
                <button class="bg-[#175729] text-white h-[50px] px-[20px] rounded-[25px]">Saya Sudah Transfer</button>
            </form>
            
            <button class="bg-[#175729] text-white h-[50px] px-[20px] rounded-[25px]">Kembali Ke Home</button>
        </div>
        
    </div>
</div>
@endsection