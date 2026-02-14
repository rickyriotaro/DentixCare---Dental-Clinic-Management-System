@extends('layouts.dokter')
@section('title','Detail Kontrol Pasien')

@section('content')
<div class="page-head" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">Detail Kontrol Pasien</div>
    <div style="color:#6b7280;margin-top:6px;">
      {{ $medicalRecord->nama_pasien ?? $medicalRecord->patient?->nama_pasien ?? '-' }}
      • {{ $medicalRecord->patient?->no_hp ?? '-' }}
      • {{ $medicalRecord->alamat ?? $medicalRecord->patient?->alamat ?? '-' }}
    </div>
  </div>

  <div style="display:flex;gap:10px;">
    <a class="btn-ghost" href="{{ route('dokter.kontrol.index') }}">Kembali</a>
    <a class="btn" href="{{ route('dokter.kontrol.create', $medicalRecord->id) }}" style="width:auto;padding:10px 16px;">
      Jadwalkan Kontrol
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap" style="margin-top:14px;">
  <table class="table">
    <tbody>
      <tr><th style="width:240px;">No RM</th><td>{{ $medicalRecord->no_rm ?? '-' }}</td></tr>
      <tr><th>Tanggal Masuk</th><td>{{ $medicalRecord->tanggal_masuk ?? '-' }}</td></tr>
      <tr><th>Keluhan</th><td>{{ $medicalRecord->keluhan ?? '-' }}</td></tr>
      <tr><th>Diagnosa Terakhir</th><td>{{ $medicalRecord->diagnosa ?? '-' }}</td></tr>
      <tr><th>Tindakan Terakhir</th><td>{{ $medicalRecord->tindakan ?? '-' }}</td></tr>
      <tr><th>Resep Obat</th><td>{{ $medicalRecord->resep_obat ?? '-' }}</td></tr>
      <tr><th>Dokter</th><td>{{ $medicalRecord->dokter?->name ?? '-' }}</td></tr>
    </tbody>
  </table>
</div>

<div class="table-card" style="margin-top:16px;">
  <div style="padding:14px 16px;font-weight:800;color:var(--pink);">Riwayat Kontrol</div>
  <table class="table-pink">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Status</th>
        <th>Catatan</th>
        <th>Dokter</th>
      </tr>
    </thead>
    <tbody>
      @forelse($medicalRecord->controls()->latest()->get() as $c)
        <tr>
          <td>{{ $c->tanggal_kontrol }}</td>
          <td>{{ $c->jam_kontrol ?? '-' }}</td>
          <td>{{ $c->status }}</td>
          <td>{{ $c->catatan ?? '-' }}</td>
          <td>{{ $c->dokter?->name ?? '-' }}</td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;padding:16px;color:#6b7280;">Belum ada kontrol.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
