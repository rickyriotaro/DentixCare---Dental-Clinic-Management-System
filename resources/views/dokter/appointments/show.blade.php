@extends('layouts.dokter')
@section('title','Detail Janji Temu')

@section('content')
  <div class="page-title">Detail Janji Temu</div>

  <div class="form-card" style="max-width:900px;">
    <div style="margin-bottom:14px; display:flex; gap:10px;">
      <a class="btn-ghost" href="{{ route('dokter.appointments.index') }}">Kembali</a>
    </div>

    <div class="detail-box">
      <div><b>Nama Pasien:</b> {{ $appointment->patient?->nama_lengkap ?? '-' }}</div>
      <div><b>Keluhan:</b> {{ $appointment->keluhan ?? '-' }}</div>
      <div><b>Tanggal Diminta:</b> {{ $appointment->tanggal_diminta ?? '-' }}</div>
      <div><b>Jam Diminta:</b> {{ $appointment->jam_diminta ?? '-' }}</div>
      <div><b>Status:</b> <span class="badge badge-{{ $appointment->status }}">{{ strtoupper($appointment->status) }}</span></div>
    </div>

    <hr class="hr">

    <div class="sub-title">Jadwal Dikonfirmasi</div>

    <div class="grid-2">
      <div class="form-row">
        <label>Tanggal Dikonfirmasi</label>
        <input type="date" class="form-input"
               value="{{ $appointment->tanggal_dikonfirmasi ?? '-' }}"
               readonly disabled
               style="background:#f3f4f6;color:#9ca3af;cursor:not-allowed;">
      </div>

      <div class="form-row">
        <label>Jam Dikonfirmasi</label>
        <input type="time" class="form-input"
               value="{{ $appointment->jam_dikonfirmasi ?? '' }}"
               readonly disabled
               style="background:#f3f4f6;color:#9ca3af;cursor:not-allowed;">
      </div>
    </div>

    @if($appointment->tanggal_dikonfirmasi)
      <div style="text-align:center;color:#16a34a;font-size:13px;margin-top:10px;font-weight:600;">
        ✅ Jadwal sudah dikonfirmasi oleh admin.
      </div>
    @else
      <div style="text-align:center;color:#6b7280;font-size:13px;margin-top:10px;">
        Jadwal belum dikonfirmasi.
      </div>
    @endif
  </div>
@endsection