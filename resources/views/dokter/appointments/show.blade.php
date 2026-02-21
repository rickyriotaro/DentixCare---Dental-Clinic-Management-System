@extends('layouts.dokter')
@section('title','Kelola Janji Temu')

@section('content')
  <div class="page-title">Kelola Janji Temu</div>

  <div class="form-card" style="max-width:900px;">
    <div style="margin-bottom:14px; display:flex; gap:10px;">
      <a class="btn-ghost" href="{{ route('dokter.appointments.index') }}">Kembali</a>

      @if($appointment->status === 'pending')
      <form method="POST" action="{{ route('dokter.appointments.reject', $appointment->id) }}">
        @csrf
        <button class="btn-danger" type="submit" onclick="return confirm('Tolak permintaan ini?')">Tolak</button>
      </form>
      @endif
    </div>

    @if ($errors->any())
      <div class="alert-error">Gagal menyimpan. Periksa input jadwal.</div>
    @endif

    <div class="detail-box">
      <div><b>Nama Pasien:</b> {{ $appointment->patient?->nama_lengkap ?? '-' }}</div>
      <div><b>Keluhan:</b> {{ $appointment->keluhan ?? '-' }}</div>
      <div><b>Tanggal Diminta:</b> {{ $appointment->tanggal_diminta ?? '-' }}</div>
      <div><b>Jam Diminta:</b> {{ $appointment->jam_diminta ?? '-' }}</div>
      <div><b>Status:</b> <span class="badge badge-{{ $appointment->status }}">{{ strtoupper($appointment->status) }}</span></div>
    </div>

    <hr class="hr">

    <div class="sub-title">Konfirmasi Jadwal (Ketersediaan Dokter)</div>

    <form method="POST" action="{{ route('dokter.appointments.approve', $appointment->id) }}">
      @csrf

      @php $isPending = $appointment->status === 'pending'; @endphp

      {{-- Shortcut: gunakan waktu dari pasien --}}
      @if($isPending)
      <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div>
          <div style="font-weight:700;color:#15803d;font-size:13px;">⏱ Waktu yang diminta pasien</div>
          <div style="color:#166534;margin-top:2px;font-size:14px;">
            📅 {{ $appointment->tanggal_diminta ?? '-' }}
            &nbsp;|&nbsp;
            🕐 {{ substr($appointment->jam_diminta ?? '', 0, 5) ?? '-' }}
          </div>
        </div>
        <button type="button"
          onclick="document.querySelector('[name=tanggal_dikonfirmasi]').value='{{ $appointment->tanggal_diminta }}';
                   document.querySelector('[name=jam_dikonfirmasi]').value='{{ substr($appointment->jam_diminta ?? '', 0, 5) }}';"
          style="background:#16a34a;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;">
          ✅ Gunakan Waktu Pasien
        </button>
      </div>
      @endif

      <div class="grid-2">
        <div class="form-row">
          <label>Tanggal Dikonfirmasi</label>
          <input type="date" class="form-input" name="tanggal_dikonfirmasi"
                 value="{{ old('tanggal_dikonfirmasi', $appointment->tanggal_dikonfirmasi) }}"
                 {{ !$isPending ? 'readonly disabled' : 'required' }}
                 style="{{ !$isPending ? 'background:#f3f4f6;color:#9ca3af;cursor:not-allowed;' : '' }}">
          @error('tanggal_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
          <label>Jam Dikonfirmasi</label>
          <input type="time" class="form-input" name="jam_dikonfirmasi"
                 value="{{ old('jam_dikonfirmasi', $appointment->jam_dikonfirmasi) }}"
                 {{ !$isPending ? 'readonly disabled' : 'required' }}
                 style="{{ !$isPending ? 'background:#f3f4f6;color:#9ca3af;cursor:not-allowed;' : '' }}">
          @error('jam_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:170px;
          {{ !$isPending ? 'opacity:0.45;cursor:not-allowed;pointer-events:none;' : '' }}"
          {{ !$isPending ? 'disabled' : '' }}>
          Setujui Jadwal
        </button>
      </div>

      @if(!$isPending)
        <div style="text-align:center;color:#6b7280;font-size:13px;margin-top:10px;">
          Jadwal sudah diproses.
        </div>
      @endif
    </form>
  </div>
@endsection