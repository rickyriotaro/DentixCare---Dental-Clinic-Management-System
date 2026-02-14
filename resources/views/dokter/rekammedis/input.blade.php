@extends('layouts.dokter')
@section('title','Input Diagnosa / Tindakan')

@section('content')
<div class="rm-head">
  <div>
    <div class="rm-title">Input Diagnosa / Tindakan</div>
    <div class="rm-sub">
      {{ $medicalRecord->patient->nama_lengkap ?? '-' }}
    </div>
  </div>

  <a class="btn-ghost" href="{{ route('dokter.rekammedis.show', $medicalRecord->id) }}" style="white-space:nowrap;">
    Kembali
  </a>
</div>

@if($errors->any())
  <div class="alert-danger" style="margin-bottom:12px;">
    <ul style="margin:0;padding-left:18px;">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="rm-card">
  <form method="POST" action="{{ route('dokter.rekammedis.saveInput', $medicalRecord->id) }}">
    @csrf

    <div class="rm-grid">
      <div class="rm-field">
        <label>Diagnosa</label>
        <textarea name="diagnosa" placeholder="Contoh: Karies gigi molar kanan..."
          required>{{ old('diagnosa', $medicalRecord->diagnosa) }}</textarea>
      </div>

      <div class="rm-field">
        <label>Tindakan</label>
        <textarea name="tindakan" placeholder="Contoh: Penambalan komposit..."
          required>{{ old('tindakan', $medicalRecord->tindakan) }}</textarea>
      </div>

      <div class="rm-field">
        <label>Resep Obat</label>
        <textarea name="resep_obat" placeholder="Contoh: Amoxicillin 500mg 3x1..."
          required>{{ old('resep_obat', $medicalRecord->resep_obat) }}</textarea>
      </div>

      <div class="rm-field">
        <label>Catatan</label>
        <textarea name="catatan" placeholder="Catatan tambahan (opsional)">{{ old('catatan', $medicalRecord->catatan) }}</textarea>
      </div>
    </div>

    <div class="rm-actions">
      <a class="btn-ghost" href="{{ route('dokter.rekammedis.show', $medicalRecord->id) }}">Batal</a>
      <button type="submit" class="btn-pink">Simpan</button>
    </div>
  </form>
</div>
@endsection
