@extends('layout.main')
@section('content')
<div class="mt-8 mx-8">
    <a href="/masjid/{{ $masjid->id }}/detail" class="hover:no-underline hover:text-slate-700">
        <div class="h-[60px] w-[1300px] flex items-center border-2">
            <i class="fa-solid fa-less-than me-4 text-2xl ms-5"></i>
            <span>Kembali ke Informasi Masjid</span>
        </div>
    </a>
    <h1 class="mt-9 text-[30px] font-semibold mb-2">Nominal Donasi</h1>
    <h1 class="text-xl font-thin text-slate-500">Minimal Donasi Rp 15.000,00</h1>
    <div class="grid grid-cols-4 gap-y-5 mt-8">
        @foreach($nominal as $i => $n)
        <button class="flex items-center border-2 w-[300px] h-[50px] rounded-[5px]" id="nominal{{ ++$i }}" onclick="nominal({{ $n->nominal }}, {{ $i }})">
           <span class="mx-auto text-xl">{{ "Rp. " . number_format($n->nominal,2,',','.') }}</span>
        </button>
        @endforeach
         <button id="inputNominal" class="flex items-center border-2 w-[300px] h-[50px] rounded-[5px]" onclick="inputNominal()">
            <span class="mx-auto text-xl">Nominal Lain</span>
         </button>
         
    </div>
    <div class="hidden" id="input">
        <h1 class="text-xl font-thin text-slate-500 mt-4 mb-2">Nominal Lain</h1>
         <input type="text" id="additional" class="h-[60px] w-[1265px] flex items-center border-2 text-xl text-slate-500 pl-16">
         <div class="absolute right-[1266px] bottom-[40px]">
            <span class="text-xl text-slate-500">Rp </span>
                
        </div>
    </div>
    <input type="checkbox" hidden id="anonim" class="hidden">
    <div class="flex items-center">
        <label for="anonim" style="cursor: pointer" class="mt-4" onclick="anonim()">
            <div class="w-[30px] h-[30px] bg-slate-300 rounded-[5px] flex items-center" id="check">
                
            </div>
        </label>
        <span class="text-xl text-slate-500 mt-[16px] ms-[10px]">Kirim sebagai anonim?</span>
    </div>
    

    <h1 class="mt-9 text-[30px] font-semibold mb-2">Metode Pembayaran</h1>
    <h1 class="text-xl font-thin text-slate-500">Pilih Metode Pembayaran Di Bawah Ini</h1>
    <div class="grid grid-cols-4 gap-y-5 mt-8">
    @foreach($bank as $i => $n)
        <button class="flex items-center border-2 w-[300px] h-[50px] rounded-[5px]" id="bank{{ ++$i }}" onclick="bank('{{ $n->nama }}', '{{ $n->nomor }}', {{ $i }})">
           <span class="mx-auto text-xl">{{ 'Bank ' . $n->nama }}</span>
        </button>
        @endforeach
    </div>
    <button class="text-2xl mb-20 mt-12 text-center h-[70px] w-[1300px] bg-[#175729] rounded-[50px] text-white" onclick="kirim()">Konfirmasi Pembayaran</button>
</div>
<form action="/pembayaran/{{ $masjid->id }}/oleh/{{ Auth::user()->id }}" method="post" id="form">
    @csrf
    <input type="hidden" id="nom" name="nominal">
    <input type="hidden" id="anon" name="anonim">
    <input type="hidden" id="metod" name="metode">
    <input type="hidden" id="norek" name="nomor">
</form>


@endsection
@push('custom_js')
<script>
    function anonim(){
        let check = document.querySelector('#check');
            if(document.querySelector('#anonim').checked){
                check.innerHTML = '';
                document.querySelector('#anon').value = null;
            } else {
                check.innerHTML = `<i class="fa-solid fa-check text-2xl mx-auto"></i>`;
                document.querySelector('#anon').value = 'Anonim';
            }
    }

    function nominal(value, id){
        for(let i = 1; i <= {{ count($nominal) }}; i++){
            document.querySelector('#nominal' + i).classList.remove('border-black');
        }
        document.querySelector('#inputNominal').classList.remove('border-black');
        document.querySelector('#nominal' + id).classList.add('border-black');
        document.querySelector('#input').classList.add('hidden');
        document.querySelector('#nom').value = value;
    }

    function bank(value, norek, id){
        for(let i = 1; i <= {{ count($bank) }}; i++){
            document.querySelector('#bank' + i).classList.remove('border-black');
            document.querySelector('#bank' + id).classList.add('border-black');
            document.querySelector('#metod').value = value;
            document.querySelector('#norek').value = norek;
        }
    }

    function inputNominal(){
        for(let i = 1; i <= {{ count($nominal) }}; i++){
            document.querySelector('#nominal' + i).classList.remove('border-black');
        }
        document.querySelector('#inputNominal').classList.add('border-black');
        document.querySelector('#input').classList.remove('hidden');
    }

    function kirim(){
        Swal.fire({
        title: 'Apakah Kamu Yakin?',
        text: "Kamu akan melakukan pembayaran di halaman selanjutnya",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kirim!'
        }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector('form').submit()
        }
        })
            }

    document.querySelector('#additional').addEventListener('blur', function(){
        document.querySelector('#nom').value = document.querySelector('#additional').value;
    })
</script>

@endpush