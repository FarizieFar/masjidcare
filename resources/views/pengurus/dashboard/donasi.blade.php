@extends('pengurus.layout.main')
@section('content')
<div>
    <div class="text-right mb-2">
        <button class="btn btn-success" data-toggle="modal" data-target="#sort">Cari Berdasarkan Tanggal</button>
        <div class="text-left modal fade" id="sort" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">Cari Berdasarkan Tanggal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="/pengurus-dashboard/data-donasi" method="get">
                <div class="modal-body mt-1">
                  <h6>Dari Tanggal: </h6>
                  <input type="date" class="form-control datepicker mb-3" name="start_date" value="{{ isset($start_date)? "$start_date" : date("Y-m-d") }}">
                  <h6>Sampai Tanggal:</h6>
                  <input type="date" class="form-control datepicker" name="end_date" value="{{ isset($end_date)? $end_date : date("Y-m-d") }}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Kirim</button>
                </form>
                </div>
              </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
    <thead>
        <td>No</td>
        <td>Nama Donatur</td>
        <td>Nominal</td>
        <td>Tanggal Donasi</td>
        <td class="text-center">Action</td>
    </thead>
    @if(count($data) != 0)
    @foreach($data as $i => $d) 
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $d->user->name }}</td>
        <td>{{ "Rp " . number_format($d->nominal,2,',','.') }}</td>
        <td>{{ $d->tanggal }}</td>
        <td class="text-center">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $i }}">Lihat Data Donatur</button>
        </td>
    </tr>
    <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Informasi Donatur</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-1">
              <h6>Nama Donatur: {{ $d->user->name }}</h6>
              <h6>Email Donatur: {{ $d->user->email }}</h6>
              <h6>No. Telp Donatur: {{ $d->user->phone }}</h6>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    @endforeach
    @else
    <tr>
        <td colspan="5"  class="text-center">Data Tidak Ditemukan!</td>
    </tr>
    @endif
  </table>
    {{ $data->links() }}
</div>
@endsection