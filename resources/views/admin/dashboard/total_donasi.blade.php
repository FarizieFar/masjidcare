@extends('admin.layout.main')
@section('content')
<table class="table table-striped">
    <thead>
        <td>No</td>
        <td>Nama Masjid</td>
        <td>Nama Pengurus</td>
        <td>Email</td>
        <td>No. Telp</td>
        <td>Total Donasi</td>
    </thead>
    @if(count($data) != 0)
    @foreach($data as $i => $d) 
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $d->nama }}</td>
        @if($d->user)
        <td>{{ $d->user->name}}</td>
        <td>{{ $d->user->email }}</td>
        <td>{{ $d->user->phone }}</td>
        @endif
        
        @if(isset($total_donasi[$d->id]))
        <td>{{ 'Rp. ' . number_format($total_donasi[$d->id],2,',','.') }}</td>
        @else
        <td>{{ 'Rp. ' . number_format(0,2,',','.') }}</td>
        @endif
    </tr>
    
    @endforeach
    @else
    <tr>
        <td colspan="5"  class="text-center">Data Tidak Ditemukan!</td>
    </tr>
    @endif
  </table>
  <div>{{ $data->links() }}</div>
@endsection