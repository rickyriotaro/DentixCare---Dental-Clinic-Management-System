@extends('layouts.admin')
@section('title','Input Rekam Medis')

@section('content')
  <div class="page-title">INPUT REKAM MEDIS</div>

  <div class="form-card" style="max-width:1000px;">
    <div style="margin-bottom:14px;">
      <a class="btn-ghost" href="{{ route('rekammedis.show',$medicalRecord->id) }}">Kembali</a>
    </div>

    @if ($errors->any())
      <div class="alert-error">Mohon lengkapi data dengan benar.</div>
    @endif

    <form method="POST" action="{{ route('rekammedis.saveInput',$medicalRecord->id) }}">
      @csrf

      <div class="form-row">
        <label>Diagnosa</label>
        <textarea class="form-textarea" name="diagnosa" required>{{ old('diagnosa',$medicalRecord->diagnosa) }}</textarea>
        @error('diagnosa') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Tindakan</label>
        <textarea class="form-textarea" name="tindakan" required>{{ old('tindakan',$medicalRecord->tindakan) }}</textarea>
        @error('tindakan') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Resep Obat</label>
        <textarea class="form-textarea" name="resep_obat" required>{{ old('resep_obat',$medicalRecord->resep_obat) }}</textarea>
        @error('resep_obat') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Catatan Tambahan</label>
        <textarea class="form-textarea" name="catatan">{{ old('catatan',$medicalRecord->catatan) }}</textarea>
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:160px;">Simpan</button>
      </div>
    </form>
  </div>
@endsection
