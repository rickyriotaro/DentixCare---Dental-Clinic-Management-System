@extends('layouts.dokter')
@section('title','Buat Rencana Perawatan')

@section('content')
<div class="page-head" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">Buat Rencana Perawatan</div>
    <div style="color:#6b7280;margin-top:6px;">
      {{ $medicalRecord->nama_pasien ?? $medicalRecord->patient?->nama_pasien ?? '-' }}
      • No RM: {{ $medicalRecord->no_rm ?? '-' }}
    </div>
  </div>
  <a class="btn-ghost" href="{{ route('dokter.perawatan.show', $medicalRecord->id) }}">Kembali</a>
</div>

@if ($errors->any())
  <div class="alert-danger" style="margin-top:10px;">
    <ul style="margin:0;padding-left:18px;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('dokter.perawatan.store', $medicalRecord->id) }}">
  @csrf

  <div class="table-wrap" style="margin-top:14px;padding:18px;background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.08);">
    <div style="display:grid;grid-template-columns:repeat(2, minmax(0,1fr));gap:14px;">
      <div>
        <label style="font-weight:700;color:#374151;">Tanggal Rencana</label>
        <input type="date" name="tanggal_rencana" value="{{ old('tanggal_rencana') }}"
               style="margin-top:6px;width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;">
      </div>

      <div>
        <label style="font-weight:700;color:#374151;">Jam Rencana</label>
        <input type="time" name="jam_rencana" value="{{ old('jam_rencana') }}"
               style="margin-top:6px;width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;">
      </div>

      <div>
        <label style="font-weight:700;color:#374151;">Status</label>
        <select name="status"
                style="margin-top:6px;width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;">
          <option value="draft" {{ old('status','draft')==='draft'?'selected':'' }}>Draft</option>
          <option value="selesai" {{ old('status')==='selesai'?'selected':'' }}>Selesai</option>
        </select>
      </div>

      <div>
        <label style="font-weight:700;color:#374151;">Judul (opsional)</label>
        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Rencana tambal gigi tahap 1"
               style="margin-top:6px;width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;">
      </div>



      <div style="grid-column:1 / -1;">
        <label style="font-weight:700;color:#374151;">Rencana Perawatan <span style="color:#ef4444;">*</span></label>
        <textarea name="rencana" rows="5" placeholder="Tuliskan rencana tindakan, tahapan, estimasi kontrol, dll."
                  style="margin-top:6px;width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;resize:vertical;">{{ old('rencana') }}</textarea>
      </div>

      <div style="grid-column:1 / -1;">
        <label style="font-weight:700;color:#374151;">Catatan (opsional)</label>
        <textarea name="catatan" rows="3" placeholder="Catatan tambahan untuk pasien"
                  style="margin-top:6px;width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:12px;outline:none;resize:vertical;">{{ old('catatan') }}</textarea>
      </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:14px;">
      <a class="btn-ghost" href="{{ route('dokter.perawatan.show', $medicalRecord->id) }}">Batal</a>
      <button type="submit" class="btn" style="width:auto;padding:12px 18px;">Simpan</button>
    </div>
  </div>
</form>
@endsection
