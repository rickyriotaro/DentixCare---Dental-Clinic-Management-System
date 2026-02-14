@extends('layouts.dokter')
@section('title','Detail Rekam Medis')

@section('content')
  <div class="page-head" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">
      Detail Rekam Medis
    </div>

    <div style="color:#6b7280;margin-top:6px;">
      {{ $medicalRecord->patient->nama_lengkap ?? '-' }}
      • {{ $medicalRecord->patient?->no_hp ?? '-' }}
      • {{ $medicalRecord->patient->alamat ?? '-' }}
    </div>
  </div>
  <a class="btn-ghost"
     href="{{ route('dokter.rekammedis.index') }}"
     style="white-space:nowrap;">
    Kembali
  </a>
</div>


  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-wrap" style="margin-top:14px;">
    <table class="table">
      <tbody>
        <tr>
          <th style="width:220px;">No RM</th>
          <td>{{ $medicalRecord->no_rm ?? '-' }}</td>
        </tr>
        <tr>
          <th>Tanggal Masuk</th>
          <td>{{ $medicalRecord->tanggal_masuk ?? '-' }}</td>
        </tr>
        <tr>
          <th>Keluhan</th>
          <td>{{ $medicalRecord->keluhan ?? '-' }}</td>
        </tr>
        <tr>
          <th>Alergi</th>
          <td>{{ $medicalRecord->alergi ?? '-' }}</td>
        </tr>
        <tr>
          <th>Riwayat Penyakit</th>
          <td>{{ $medicalRecord->riwayat_penyakit ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diagnosa</th>
          <td>{{ $medicalRecord->diagnosa ?? '-' }}</td>
        </tr>
        <tr>
          <th>Tindakan</th>
          <td>{{ $medicalRecord->tindakan ?? '-' }}</td>
        </tr>
        <tr>
          <th>Resep Obat</th>
          <td>{{ $medicalRecord->resep_obat ?? '-' }}</td>
        </tr>
        <tr>
          <th>Catatan</th>
          <td>{{ $medicalRecord->catatan ?? '-' }}</td>
        </tr>
        <tr>
          <th>Dokter</th>
          <td>{{ $medicalRecord->dokter?->name ?? '-' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
