@extends('layouts.admin')
@section('title','Kelola Janji Temu')

@section('content')
  <div class="page-title">Kelola Janji Temu</div>

  <div class="form-card" style="max-width:900px;">
    <div style="margin-bottom:14px; display:flex; gap:10px;">
      <a class="btn-ghost" href="{{ route('appointments.index') }}">Kembali</a>

      @if($appointment->status === 'pending')
      <form method="POST" action="{{ route('appointments.reject', $appointment->id) }}">
        @csrf
        <button class="btn-danger" type="submit" onclick="return confirm('Tolak permintaan ini?')">Tolak</button>
      </form>
      @endif
    </div>

    @if ($errors->any())
      <div class="alert-error">Gagal menyimpan. Periksa input jadwal.</div>
    @endif

    <div class="detail-box">
      <div><b>Nama Pasien:</b> {{ $appointment->patient->nama_pasien ?? '-' }}</div>
      <div><b>Keluhan:</b> {{ $appointment->keluhan ?? '-' }}</div>
      <div><b>Tanggal Diminta:</b> {{ $appointment->tanggal_diminta ?? '-' }}</div>
      <div><b>Jam Diminta:</b> {{ $appointment->jam_diminta ?? '-' }}</div>
      <div><b>Status:</b> <span class="badge badge-{{ $appointment->status }}">{{ strtoupper($appointment->status) }}</span></div>
    </div>

    <hr class="hr">

    <div class="sub-title">Konfirmasi Jadwal (Ketersediaan Dokter)</div>

    <form method="POST" action="{{ route('appointments.approve', $appointment->id) }}">
      @csrf

      <div class="grid-2">
        <div class="form-row">
          <label>Tanggal Dikonfirmasi</label>
          <input type="date" class="form-input" name="tanggal_dikonfirmasi"
                 value="{{ old('tanggal_dikonfirmasi', $appointment->tanggal_dikonfirmasi) }}" required>
          @error('tanggal_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
          <label>Jam Dikonfirmasi</label>
          <input type="time" class="form-input" name="jam_dikonfirmasi"
                 value="{{ old('jam_dikonfirmasi', $appointment->jam_dikonfirmasi) }}" required>
          @error('jam_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:170px;"
          @if($appointment->status !== 'pending') disabled @endif>
          Setujui Jadwal
        </button>
      </div>

      @if($appointment->status !== 'pending')
        <div style="text-align:center;color:#6b7280;font-size:13px;margin-top:10px;">
          Jadwal sudah diproses.
        </div>
      @endif
    </form>
  </div>
@endsection
