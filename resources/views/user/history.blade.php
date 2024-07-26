@extends('layout.main')
@section('content')
<h1 class="text-2xl font-semibold text-center mt-8 mb-8">Histori Donasi</h1>
<div class="ms-12 mb-36">
    <div class="grid grid-cols-3 gap-x-5 gap-y-2">
        @foreach($history as $h)
        <div class="w-[400px] border-4 text-center">
        
            <span class="text-xs text-slate-400">{{ $h->tanggal }}</span>
            <h1 class="text-2xl">Tujuan: {{ $h->masjid->nama }}</h1>
            <h1>Nominal: {{ "Rp. " . number_format($h->nominal,2,',','.') }}</h1>
            @if($h->isAnonim === 'True')
            <span class="text-red-500 text-xs">Sebagai Anonim</span><br>
            @else 
            <span class="text-red-500 text-xs">Bukan Sebagai Anonim</span><br>
            @endif
            <span>Metode: Bank {{ $h->metode->nama }}</span><br>
            @if($h->isProcessed === 'False')
            <span>Nomor Rekening: {{ $h->metode->nomor }}</span>
            <button class="bg-[#175729] text-white w-[300px] h-[40px] rounded-[25px] mt-4 mb-2" onclick="pay('{{ $h->snap_token }}')">Transfer</button>
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
@push('custom_js')
<script type="text/javascript">
function pay(kode){
    window.snap.pay(kode, {
      onSuccess: function(result){
        /* You may add your own implementation here */
        Swal.fire({
          icon: 'success',
          title: 'Yeay...',
          text: 'Pembayaran Berhasil!'
        }).then((result) => {
          if(result.isConfirmed){
            window.location.href = '/history';
          }
        });
      },
      onPending: function(result){
        /* You may add your own implementation here */
        Swal.fire({
          icon: 'warning',
          title: 'Wait...',
          text: 'Pembayaran Pending!'
        });
      },
      onError: function(result){
        /* You may add your own implementation here */
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Pembayaran Gagal!'
        });
      }
    })
}
</script>
@endpush