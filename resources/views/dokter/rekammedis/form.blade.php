@extends('layouts.dokter')
@section('title', $mode === 'edit' ? 'Edit Rekam Medis' : 'Tambah Rekam Medis')

@section('content')
  <div class="page-head" style="display:flex;justify-content:space-between;align-items:center;">
    <div class="page-title" style="color:var(--pink);font-weight:900;">
      {{ $mode === 'edit' ? 'Edit Detail Rekam Medis' : 'Tambah Detail Rekam Medis' }}
    </div>
    <a class="btn" href="{{ route('dokter.rekammedis.show', $patient->id) }}" style="width:auto;padding:10px 16px;background:#fff;color:var(--pink);border:2px solid var(--pink);">
      Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert-danger" style="margin-top:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="card" style="margin-top:14px;padding:18px;">
    <div style="font-weight:800;margin-bottom:12px;">
      Pasien: {{ $patient->nama_pasien }} ({{ $patient->no_hp }})
    </div>

    <form method="POST"
      action="{{ $mode === 'edit'
        ? route('dokter.rekammedis.update', [$patient->id, $record->id])
        : route('dokter.rekammedis.store', $patient->id) }}">
      @csrf
      @if($mode === 'edit') @method('PUT') @endif

      <div class="grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div class="group">
          <span class="label">No RM</span>
          <input class="input" name="no_rm" value="{{ old('no_rm', $record->no_rm) }}" required>
        </div>
        <div class="group">
          <span class="label">Tanggal Masuk</span>
          <input class="input" type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $record->tanggal_masuk) }}" required>
        </div>
      </div>

      <div class="group" style="margin-top:10px;">
        <span class="label">Keluhan</span>
        <input class="input" name="keluhan" value="{{ old('keluhan', $record->keluhan) }}">
      </div>

      <div class="grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:10px;">
        <div class="group">
          <span class="label">Alergi</span>
          <input class="input" name="alergi" value="{{ old('alergi', $record->alergi) }}">
        </div>
        <div class="group">
          <span class="label">Riwayat Penyakit</span>
          <input class="input" name="riwayat_penyakit" value="{{ old('riwayat_penyakit', $record->riwayat_penyakit) }}">
        </div>
      </div>

      <div class="group" style="margin-top:10px;">
        <span class="label">Diagnosa</span>
        <textarea class="input" name="diagnosa" rows="2">{{ old('diagnosa', $record->diagnosa) }}</textarea>
      </div>

      <div class="group" style="margin-top:10px;">
        <span class="label">Tindakan</span>
        <textarea class="input" name="tindakan" rows="2">{{ old('tindakan', $record->tindakan) }}</textarea>
      </div>

      <div class="group" style="margin-top:10px;">
        <span class="label">Resep Obat</span>
        <textarea class="input" name="resep_obat" rows="2">{{ old('resep_obat', $record->resep_obat) }}</textarea>
      </div>

      <div class="group" style="margin-top:10px;">
        <span class="label">Catatan</span>
        <textarea class="input" name="catatan" rows="3">{{ old('catatan', $record->catatan) }}</textarea>
      </div>

      <button class="btn" type="submit" style="margin-top:14px;">
        Simpan
      </button>
    </form>
  </div>
@endsection
