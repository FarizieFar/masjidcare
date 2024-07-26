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
        <div class="text-center mt-8">
                <button class="bg-[#175729] mb-2 text-white h-[50px] px-[20px] rounded-[25px]" id="pay-button">Transfer</button>
            
            <a href="/history"><button class="bg-[#175729] text-white h-[50px] px-[20px] rounded-[25px]">Ke History</button></a>
        </div>
        
    </div>
    <div id="snap-container"></div>
</div>
@endsection
@push('custom_js')
<script type="text/javascript">
  // For example trigger on button clicked, or any time you need
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay('{{ $donasi->snap_token }}', {
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
        })
      }
    })
  });
</script>
@endpush

