@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
  <div class="page-title" style="color: var(--pink); font-weight:900;">
    Dashboard Dokter
  </div>

  <div class="cards" style="margin-top:18px;">
    <div class="card">
      <div class="ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </div>
      <div>
        <div class="val">{{ $jumlahSelesai }}</div>
        <div class="desc">Jumlah pasien selesai ditangani</div>
      </div>
    </div>

    <div class="card">
      <div class="ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M4 21v-2a4 4 0 0 1 3-3.87"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </div>
      <div>
        <div class="val">{{ $jumlahProses }}</div>
        <div class="desc">Jumlah pasien ditangani</div>
      </div>
    </div>

    <div class="card">
      <div class="ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="14" rx="2"/>
          <path d="M7 20h10"/>
        </svg>
      </div>
      <div>
        <div class="val">{{ $noAntrian }}</div>
        <div class="desc">No.Antrian</div>
      </div>
    </div>
  </div>
@endsection
