<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Data Donasi</title>
</head>
<body>
    <h1 class="text-center mb-4">Data Donasi Masjid "{{ Auth::user()->masjid->nama }}"</h1>
    <h6>Nama Pengurus: {{ Auth::user()->name }}</h6>
    <h6>Email Pengurus: {{ Auth::user()->email }}</h6>
    <h6 class="mb-4">No. Handphone Pengurus: {{ Auth::user()->phone }}</h6>
    <table class="table caption-top">
        <thead>
            <td>Nama Donatur</td>
            <td>Nominal</td>
            <td>Tanggal Donasi</td>
        </thead>
        @foreach($donasi as $d)
        <tr>
            <td>{{ $d->user->name }}</td>
            <td>{{ "Rp " . number_format($d->nominal,2,',','.') }}</td>
            <td>{{ $d->tanggal }}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>