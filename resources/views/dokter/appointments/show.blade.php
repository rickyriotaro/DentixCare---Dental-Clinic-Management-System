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

    {{-- Shortcut Buttons: Aksi Cepat --}}
    @if($appointment->status === 'approved' && $appointment->patient)
      @php $medicalRecord = $appointment->patient->medicalRecords->first(); @endphp
      @if($medicalRecord)
        <hr class="hr" style="margin:24px 0;">
        <div style="background:#f0f9ff;border:1.5px solid #93c5fd;border-radius:12px;padding:20px;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
            <span style="font-size:18px;">⚡</span>
            <span style="font-weight:700;color:#1e40af;font-size:15px;">Aksi Cepat</span>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:12px;">
            <a href="{{ route('dokter.rekammedis.input', $medicalRecord->id) }}"
               style="display:inline-flex;align-items:center;gap:8px;background:#2563eb;color:#fff;padding:10px 20px;border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">
              📝 Isi Rekam Medis
            </a>
            <a href="{{ route('dokter.perawatan.create', $medicalRecord->id) }}"
               style="display:inline-flex;align-items:center;gap:8px;background:#7c3aed;color:#fff;padding:10px 20px;border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">
              📋 Buat Rencana Perawatan
            </a>
          </div>
          <div style="margin-top:10px;font-size:12px;color:#6b7280;">
            Pasien: <strong>{{ $appointment->patient->nama_lengkap }}</strong> — No. RM: <strong>{{ $medicalRecord->no_rm }}</strong>
          </div>
        </div>
      @else
        <hr class="hr" style="margin:24px 0;">
        <div style="background:#fef3c7;border:1px solid #fbbf24;border-radius:10px;padding:14px;text-align:center;font-size:13px;color:#92400e;">
          ⚠️ Pasien ini belum memiliki rekam medis. Buat rekam medis terlebih dahulu di menu <strong>Rekam Medis</strong>.
        </div>
      @endif
    @endif
  </div>
@endsection