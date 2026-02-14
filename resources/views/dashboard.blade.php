@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
  <div class="h1">Dashboard Admin</div>

  <section class="cards">
    <div class="card">
      <div class="ic">
         <i class="fa-solid fa-user-check"></i>
      </div>
      <div>
        <div class="val">{{ $selesai }}</div>
        <div class="desc">Jumlah pasien selesai ditangani</div>
      </div>
    </div>

    <div class="card">
      <div class="ic">
        <i class="fa-solid fa-user"></i>
      </div>
      <div>
        <div class="val">{{ $ditangani }}</div>
        <div class="desc">Jumlah pasien ditangani</div>
      </div>
    </div>

    <div class="card">
      <div class="ic">
        <i class="fa-solid fa-ticket"></i>
      </div>
      <div>
        <div class="val">{{ $antrian }}</div>
        <div class="desc">No.Antrian</div>
      </div>
    </div>
  </section>
@endsection
