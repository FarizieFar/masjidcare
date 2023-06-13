@extends('pengurus.layout.main')
@section('content')
<div class="mb-5">
    <input type="hidden" value="{{ Auth::user()->masjid->saldo }}" id="hiddenValue" >
    <form action="/tarik-dana" id="formTarik" method="POST" enctype="multipart/form-data" onsubmit="kirimDokumen()">
        @csrf
    <label for="">Masukkan Nominal Yang Ingin Dicairkan (Saldo: {{ 'Rp. '. number_format(Auth::user()->masjid->saldo,2,',','.') }})</label>
    <div class="input-group mb-1">
        <span class="input-group-text">Rp. </span>
        <input type="text" class="form-control" value="0" name="tarik" id="tarik" onkeypress="antiAngka()" required>
    </div>

    <div class="text-right text-primary ">
    <span id="tarikSemua" style="cursor: pointer" onclick="tarikSemua()">Tarik Semua</span>
    </div>
    <label for="">Masukkan File</label>
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="dokumen" name="dokumen" required>
    </div>

    @if(Auth::user()->masjid->nomor_rekening == null)
    <label for="">Masukkan Nama Bank</label>
    <div class="input-group mb-3">
        <select class="form-select" name="bank" required>
            @foreach($bank as $b)
            <option value="{{ $b }}">{{ $b }}</option>
            @endforeach
          </select>
    </div>
    <label for="">Masukan Nomor Rekening</label>
    <input type="text" class="form-control mb-3" name="norek" required>
    @endif
    <button class="btn btn-primary" style="width: 100%">Kirim</button>
</form>
</div>
<div>
    <h3 class="mb-4">Histori Pencairan</h3>
        @foreach($pencairan as $i => $p)
    <div class="card">
        @if($p->status === 'Pending')
        <h5 class="card-header bg-warning">{{ $p->status }}</h5>
        @elseif($p->status === 'Approved')
        <h5 class="card-header bg-success">{{ $p->status }}</h5>
        @else
        <h5 class="card-header bg-danger">{{ $p->status }}</h5>
        @endif
        <div class="card-body">
            <span class="small text-gray">{{ $p->tanggal }} ({{ \Carbon\Carbon::parse($p->tanggal)->diffForHumans() }})</span>
          <p class="card-text">Nominal: {{ "Rp " . number_format($p->nominal,2,',','.') }}</p>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdf{{ ++$i }}">
            Lihat PDF
          </button>
        </div>
      </div>
      <div class="modal fade" id="pdf{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Laporan PDF</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <embed src="{{ asset('storage/' . $p->pdf_laporan) }}" width="450" height="375" 
                type="application/pdf">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
</div>


@endsection
@push('custom_js')
<script>
    function tarikSemua(){
        let value = document.querySelector('#hiddenValue').value;
        let input = document.querySelector('#tarik');
        input.value = value;
    }

    function antiAngka(){
        const inputElement = document.getElementById('tarik');

        // Periksa apakah nilai input bukan angka
        if (isNaN(inputElement)) {
            // Jika bukan angka, hapus karakter terakhir dari input
            event.target.value = inputValue.slice(0, -1);
        }
        }

        function kirimDokumen(){
            event.preventDefault()
            Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu akan membuat request pencairan dana",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#formTarik').submit();
            }
            })
        }

</script>
@endpush