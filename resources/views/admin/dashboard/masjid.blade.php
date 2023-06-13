@extends('admin.layout.main')
@section('content')
<div class="mt-3">
    @if(count($data) != 0)
    <div class="row">
        @foreach($data as $i => $m)
        @if($m->level == 'pengurus')
        <div class="col-md-3 col-sm-6">
            <div class="card rounded shadow-lg" style="width: 16rem;">
                <img class="rounded" src="{{ $m->masjid->foto }}" class="card-img-top" alt="...">
                <div class="card-body">
                <div>
                    @if($m->masjid->request == 'approved')
                  <div class="bg-success rounded text-center">
                    <span class="small">Diterima</span>
                  </div>
                  @elseif($m->masjid->request == 'declined')
                  <div class="bg-danger rounded text-center">
                    <span class="small">Ditolak</span>
                  </div>
                  @else
                  <div class="bg-warning rounded text-center">
                    <span class="small">Pending</span>
                  </div>
                  @endif
                    <h6 class="small text-gray">{{ $m->masjid->alamat }}</h6>
                  <h5 class="card-title mb-3"><b>{{ $m->masjid->nama }}</b> ({{ $m->masjid->luas }} m<sup>2</sup>)</h5>
                </div>
                  <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $i }}">
                        Lihat Detail
                      </button>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="exampleModal{{ $i++ }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <h6>Nama Masjid: {{ $m->masjid->nama }}</h6>
                      <h6>Alamat Masjid: {{ $m->masjid->alamat }}</h6>
                      <h6>Luas Masjid: {{ $m->masjid->luas }} m<sup>2</sup></h6>
                      <h6>
                        Surat Masjid: <a href="{{ asset('/storage/' . $m->masjid->surat) }}" target="_blank">Buka</a>
                      </h6>
                      <h6>
                        Foto Masjid: <a href="{{ asset('/storage/' . $m->masjid->foto) }}" target="_blank">Buka</a>
                      </h6>
                      <h5 class="mt-5 mb-3">Pengurus Masjid</h5>
                      <h6>Nama Pengurus: {{ $m->name }}</h6>
                      <h6>Email Pengurus: {{ $m->email }}</h6>
                      <h6>No. Handphone Pengurus: {{ $m->phone }}</h6>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @else
        <div>
            Data Tidak Ditemukan!
        </div>
    @endif
</div>
@endsection