@extends('layouts.admin')
@section('title','Detail Rekam Medis')

@section('content')
  <div class="page-head">
    <div class="page-title">DETAIL REKAM MEDIS</div>
    <a class="btn-ghost" href="{{ route('rekammedis.index') }}">Kembali</a>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="form-card" style="max-width:1000px;">
    <div class="detail-box">
      <div><b>No.RM:</b> {{ $medicalRecord->no_rm }}</div>
      <div><b>Nama Pasien:</b> {{ $medicalRecord->patient->nama_lengkap ?? '-' }}</div>
      <div><b>Alamat:</b> {{ $medicalRecord->patient->alamat ?? '-' }}</div>
      <div><b>Tanggal Masuk:</b> {{ $medicalRecord->tanggal_masuk }}</div>
      <div><b>Keluhan:</b> {{ $medicalRecord->keluhan ?? '-' }}</div>
      <div><b>Alergi:</b> {{ $medicalRecord->alergi ?? '-' }}</div>
      <div><b>Riwayat Penyakit:</b> {{ $medicalRecord->riwayat_penyakit ?? '-' }}</div>
    </div>

    <hr class="hr">

    <div class="sub-title">Isi Rekam Medis</div>
    <div class="detail-box">
      <div><b>Diagnosa:</b> {{ $medicalRecord->diagnosa ?? '-' }}</div>
      <div><b>Tindakan:</b> {{ $medicalRecord->tindakan ?? '-' }}</div>
      <div><b>Resep Obat:</b> {{ $medicalRecord->resep_obat ?? '-' }}</div>
      <div><b>Catatan:</b> {{ $medicalRecord->catatan ?? '-' }}</div>
    </div>

    <div class="form-actions" style="justify-content:flex-end;gap:12px;margin-top:16px;">
      <a class="btn-ghost" href="{{ route('rekammedis.index') }}">Kembali</a>
      @auth
        @if(auth()->user()->role === 'dokter')
          <a class="btn-primary"
             href="{{ route('dokter.perawatan.create', $medicalRecord->id) }}"
             style="background:#e91e8c;color:#fff;padding:8px 20px;border-radius:8px;text-decoration:none;font-weight:600;">
            + Buat Rencana Perawatan
          </a>
        @endif
      @endauth
    </div>
  </div>
@endsection
