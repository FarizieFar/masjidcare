@extends('admin.layout.main')
@section('content')
<div class="mt-3">
    <div class="row">
        @foreach($donasi as $i => $d)
        <div class="col-md-3">
            <div class="card" style="width: 16rem;">
                <div class="card-body">
                <span class="small text-gray">{{ $d->tanggal }} ({{ Carbon\Carbon::parse($d->tanggal)->diffForHumans() }})</span>
                  <h5 class="">{{ (strlen($d->user->name) > 15) ? substr($d->user->name, 0, 15) .'...' : $d->user->name }}</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Nominal: {{ 'Rp. ' . number_format($d->nominal,2,',','.') }}</h6>
                  <h6 class="">Metode Pembayaran: {{ $d->metode->nama }}</h6>
                  <h6>Masjid Tujuan: {{ $d->masjid->nama }}</h6>
                  <button class="btn btn-success" id="app{{ ++$i }}" onclick="approve({{ $i }})">Terima</button>
                  <button class="btn btn-danger" id="dec{{ $i }}" onclick="decline({{ $i }})">Tolak</button>
                  <button class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal{{ $i }}">Detail</button>
                </div>
              </div>
        </div>
        <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">Informasi</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body mt-1">
                    <h5 class="mb-3">Masjid</h5>
                  <h6>Nama Masjid: {{ $d->masjid->nama }}</h6>
                  <h6>Alamat Masjid: {{ $d->masjid->alamat }}</h6>
                  <h6>Luas Masjid: {{ $d->masjid->luas }} m<sup>2</sup></h6>
                  <h6>
                    Foto Masjid: <a href="{{ asset('/storage/' . $d->masjid->foto) }}" target="_blank">Buka</a>
                  </h6>
                  <h5 class="mt-5 mb-3">Donatur</h5>
                  <h6>Nama Donatur: {{ $d->user->name }}</h6>
                  <h6>Email Donatur: {{ $d->user->email }}</h6>
                  <h6>No. Handphone Donatur: {{ $d->user->phone }}</h6>
                  <h5 class="mt-5">Nominal: {{ 'Rp. ' . number_format($d->nominal,2,',','.') }}</h5>
                  <h5>Metode Pembayaran:{{ $d->metode->nama }}</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>
        <form action="/admin-dashboard/approve-donasi/{{ $d->id }}" method="post" id="approve{{ $i }}">
            @csrf
            <input type="hidden" name="masjid" value="{{ $d->masjid->id }}">
        </form>
        <form action="/admin-dashboard/decline-donasi/{{ $d->id }}" method="post" id="decline{{ $i }}">
            @csrf
        </form>
        @endforeach
    </div>
</div>
@endsection
@push('custom_js')
<script>
    function approve(value){
        Swal.fire({
            title: 'Apa Kamu Yakin?',
            text: "Apakah kamu yakin untuk menerima data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, terima'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#approve' + value).submit();
            }
            })
    }

    function decline(value){
        Swal.fire({
            title: 'Apa Kamu Yakin?',
            text: "Apakah kamu yakin untuk menolak data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#decline' + value).submit();
            }
            })
    }
</script>
@endpush