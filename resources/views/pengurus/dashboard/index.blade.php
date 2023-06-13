@extends('pengurus.layout.main')
@section('content')
<div>
  <div class="row">
    <div class="col-lg-3">
        <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $jumlah_donasi }}</h3>

              <p>Jumlah Donasi</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-filing"></i>
            </div>
            <a href="/admin-dashboard/data-donasi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
    </div>
    <div class="col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
              <h3>Rp. {{ $total_donasi }}</h3>

              <p>Total Donasi</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="/admin-dashboard/data-donasi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
    </div>
    <div class="col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
              <h3>Rp. {{ $dicairkan }}</h3>

              <p>Dana Ditarik</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="/admin-dashboard/data-donasi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
    </div>
    <div class="col-lg-3">
        <div class="small-box bg-danger">
            <div class="inner">
              <h3>Rp. {{ $saldo }}</h3>

              <p>Saldo</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-usd"></i>
            </div>
            <a href="/admin-dashboard/data-donasi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
    </div>
    </div>  
</div>
@endsection