@extends('admin.layout.main')
@section('content')
<div>
    @if(count($pencairan) != 0)
    <div class="row">
        @foreach($pencairan as $i => $p)
        <div class="col-md-3">
            <div class="card" style="width: 16rem;">
                <div class="card-body">
                <span class="small text-gray">{{ $p->tanggal }} ({{ \Carbon\Carbon::parse($p->tanggal)->diffForHumans() }})</span>
                  <h5 class="mb-3">{{ $p->masjid->nama }} </h5>
                  <p class="card-text">Nominal: {{ 'Rp. '. number_format($p->nominal,2,',','.') }} <br>Bank: {{ $p->masjid->bank }}<br> No. Rekening: {{ $p->masjid->nomor_rekening }}</p>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdf{{ ++$i }}">
                    <i class="fa-solid fa-file"></i>
                  </button>
                  <button class="btn btn-success"><i class="fa-solid fa-check" onclick="terima({{ $i }})"></i></button>
                  <button class="btn btn-danger"><i class="fa-solid fa-xmark" onclick="tolak({{ $i }})"></i></button>
                  <form action="/admin-dashboard/terima-pencairan/{{ $p->id }}" method="post" id="approve{{ $i }}">
                    @csrf
                </form>
                <form action="/admin-dashboard/tolak-pencairan/{{ $p->id }}" method="post" id="decline{{ $i }}">
                    @csrf
                </form>
                </div>
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
    @else
    @endif
</div>
@endsection
@push('custom_js')
<script>
    function terima(value){
            Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu akan menerima permintaan pencairan ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#approve' + value).submit();
            }
            })
    }

    function tolak(value){
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu akan menolak permintaan pencairan ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#decline' + value).submit();
            }
            })

    }
</script>
@endpush