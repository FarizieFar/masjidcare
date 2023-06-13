@extends('admin.layout.main')
@section('content')
<table class="table table-striped">
    <thead>
        <td>No</td>
        <td>Nama</td>
        <td>Email</td>
        <td>No. Telp</td>
        <td class="text-center">Action</td>
    </thead>
    @if(count($data) != 0)
    @foreach($data as $i => $d) 
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $d->name }}</td>
        <td>{{ $d->email }}</td>
        <td>{{ $d->phone }}</td>
        <td class="text-center">
            <form action="/admin-dashboard/donatur/delete/{{ $d->id }}" id="delete{{ $i }}">
                <button class="btn btn-danger" onclick="deletes({{ $i }})">Hapus Data</button>
            </form>
        </td>
    </tr>
    
    @endforeach
    @else
    <tr>
        <td colspan="5"  class="text-center">Data Tidak Ditemukan!</td>
    </tr>
    @endif
  </table>
@endsection
<script>
    function deletes(value){
        event.preventDefault();
        Swal.fire({
            title: 'Apa Kamu Yakin?',
            text: "Apakah kamu yakin untuk menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus'
            }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#delete' + value).submit();
            }
            })
    }
</script>