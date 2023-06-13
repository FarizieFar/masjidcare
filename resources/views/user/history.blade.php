@extends('layout.main')
@section('content')
<h1 class="text-2xl font-semibold text-center mt-8 mb-8">Histori Donasi</h1>
<div class="ms-12 mb-36">
    <div class="grid grid-cols-3 gap-x-5">
        @foreach($history as $h)
        <div class="w-[400px] border-4 text-center">
        
            <span class="text-xs text-slate-400">{{ $h->tanggal }}</span>
            <h1 class="text-2xl">Tujuan: {{ $h->masjid->nama }}</h1>
            <h1>Nominal: {{ "Rp. " . number_format($h->nominal,2,',','.') }}</h1>
            @if($h->isAnonim === 'True')
            <span class="text-red-500 text-xs">Sebagai Anonim</span><br>
            @else 
            <span class="text-red-500 text-xs">>Bukan Sebagai Anonim</span><br>
            @endif
            <span>Metode: Bank {{ $h->metode->nama }}</span><br>
            @if($h->isProcessed === 'False')
            <span>Nomor Rekening: {{ $h->metode->nomor }}</span>
            <form class="mt-8 mb-4" action="/sudah-transfer/{{ $h->id }}" method="post">
                @csrf
            <button class="bg-[#175729] text-white w-[300px] h-[40px] rounded-[25px]">Saya sudah transfer</button>
            </form>
            @else
            @if($h->status === 'Pending')
            <div class="ms-10">
                <div class="bg-yellow-500 text-white w-[300px] h-[40px] rounded-[25px] flex items-center mt-14 mb-4">
                    <span class="text-base mx-auto">Pending</span>
                </div>
            </div>
            @elseif($h->status === 'Approved')
            <div class="ms-10">
                <div class="bg-green-600 text-white w-[300px] h-[40px] rounded-[25px] flex items-center mt-14 mb-4">
                    <span class="text-base mx-auto">Success</span>
                </div>
            </div>
            @else
            <div class="ms-10">
                <div class="bg-red-500 text-white w-[300px] h-[40px] rounded-[25px] flex items-center mt-14 mb-4">
                    <span class="text-base mx-auto">Failed</span>
                </div>
            </div>
            @endif
            @endif
        </div>
        @endforeach
    </div>
</div>



@endsection