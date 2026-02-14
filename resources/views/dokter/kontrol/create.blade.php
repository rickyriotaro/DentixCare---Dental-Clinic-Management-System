@extends('layouts.dokter')
@section('title','Jadwalkan Kontrol')

@section('content')
<div class="page-head" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">Jadwalkan Kontrol</div>
    <div style="color:#6b7280;margin-top:6px;">
      {{ $medicalRecord->nama_pasien ?? $medicalRecord->patient?->nama_pasien ?? '-' }}
      • No RM: {{ $medicalRecord->no_rm ?? '-' }}
    </div>
  </div>

  <a class="btn-ghost" href="{{ route('dokter.kontrol.show', $medicalRecord->id) }}">Kembali</a>
</div>

@if ($errors->any())
  <div class="alert-danger" style="margin-top:12px;">
    <ul style="margin:0;padding-left:18px;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('dokter.kontrol.store', $medicalRecord->id) }}" style="margin-top:14px;">
  @csrf

  <div class="table-card" style="padding:16px;">
    <div style="
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:14px;
      align-items:end;
    ">
      <div>
        <label style="font-weight:700;">Tanggal Kontrol</label>
        <input type="date" name="tanggal_kontrol" value="{{ old('tanggal_kontrol') }}"
          style="width:100%;margin-top:6px;padding:10px 12px;border:1.5px solid #ffd1e6;border-radius:12px;outline:none;">
      </div>

      <div>
        <label style="font-weight:700;">Jam (opsional)</label>
        <input type="time" name="jam_kontrol" value="{{ old('jam_kontrol') }}"
          style="width:100%;margin-top:6px;padding:10px 12px;border:1.5px solid #ffd1e6;border-radius:12px;outline:none;">
      </div>

      <div style="grid-column:1 / -1;">
        <label style="font-weight:700;">Catatan (opsional)</label>
        <textarea name="catatan" rows="4"
          style="width:100%;margin-top:6px;padding:10px 12px;border:1.5px solid #ffd1e6;border-radius:12px;outline:none;resize:vertical;">{{ old('catatan') }}</textarea>
      </div>

      <div style="grid-column:1 / -1;display:flex;justify-content:flex-end;gap:10px;">
        <a class="btn-ghost" href="{{ route('dokter.kontrol.show', $medicalRecord->id) }}">Batal</a>
        <button class="btn" type="submit" style="width:auto;padding:10px 18px;">Simpan</button>
      </div>
    </div>
  </div>
</form>
@endsection
