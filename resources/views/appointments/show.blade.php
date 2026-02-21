@extends('layouts.admin')
@section('title','Kelola Janji Temu')

@section('content')
  <div class="page-title">Kelola Janji Temu</div>

  <div class="form-card" style="max-width:900px;">
    <div style="margin-bottom:14px; display:flex; gap:10px;">
      <a class="btn-ghost" href="{{ route('appointments.index') }}">Kembali</a>

      @if($appointment->status === 'pending')
      <form method="POST" action="{{ route('appointments.reject', $appointment->id) }}"
            id="reject-form" style="display:flex;flex-direction:column;gap:8px;background:#fff5f5;padding:12px;border-radius:8px;border:1px solid #fca5a5;margin-bottom:12px;">
        @csrf
        <div style="font-weight:600;color:#dc2626;">Tolak & Informasikan ke Pasien</div>
        <textarea name="alasan" rows="2" placeholder="Tulis alasan/informasi untuk pasien (wajib)..."
          style="width:100%;border:1px solid #fca5a5;border-radius:6px;padding:8px;font-size:13px;resize:vertical;"
          required></textarea>
        <div>
          <button class="btn-danger" type="submit" onclick="return confirm('Tolak dan kirim informasi ke pasien?')">
            Tolak & Kirim Notifikasi
          </button>
        </div>
      </form>
      @endif
    </div>

    @if ($errors->any())
      <div class="alert-error">Gagal menyimpan. Periksa input jadwal.</div>
    @endif

    <div class="detail-box">
      <div><b>Nama Pasien:</b> {{ $appointment->patient->nama_pasien ?? '-' }}</div>
      <div><b>Keluhan:</b> {{ $appointment->keluhan ?? '-' }}</div>
      <div><b>Tanggal Diminta:</b> {{ $appointment->tanggal_diminta ?? '-' }}</div>
      <div><b>Jam Diminta:</b> {{ $appointment->jam_diminta ?? '-' }}</div>
      <div><b>Status:</b> <span class="badge badge-{{ $appointment->status }}">{{ strtoupper($appointment->status) }}</span></div>
    </div>

    <hr class="hr">

    <div class="sub-title">Konfirmasi Jadwal (Ketersediaan Dokter)</div>

    <form method="POST" action="{{ route('appointments.approve', $appointment->id) }}">
      @csrf

      @php $isPending = $appointment->status === 'pending'; @endphp

      {{-- Shortcut: gunakan waktu dari pasien --}}
      @if($isPending)
      <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div>
          <div style="font-weight:700;color:#15803d;font-size:13px;">⏱ Waktu yang diminta pasien</div>
          <div style="color:#166534;margin-top:4px;font-size:14px;">
            📅 {{ $appointment->tanggal_diminta ?? '-' }}
            &nbsp;|&nbsp;
            🕐 {{ substr($appointment->jam_diminta ?? '', 0, 5) }}
          </div>
        </div>
        <button type="button"
          onclick="document.querySelector('[name=tanggal_dikonfirmasi]').value='{{ $appointment->tanggal_diminta }}';
                   document.querySelector('[name=jam_dikonfirmasi]').value='{{ substr($appointment->jam_diminta ?? '', 0, 5) }}';"
          style="background:#16a34a;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;white-space:nowrap;">
          ✅ Gunakan Waktu Pasien
        </button>
      </div>
      @endif

      <div class="grid-2">
        <div class="form-row">
          <label>Tanggal Dikonfirmasi</label>
          <input type="date" class="form-input" name="tanggal_dikonfirmasi"
                 value="{{ old('tanggal_dikonfirmasi', $appointment->tanggal_dikonfirmasi) }}" required>
          @error('tanggal_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
          <label>Jam Dikonfirmasi</label>
          <input type="time" class="form-input" name="jam_dikonfirmasi"
                 value="{{ old('jam_dikonfirmasi', $appointment->jam_dikonfirmasi) }}" required>
          @error('jam_dikonfirmasi') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:170px;"
          @if($appointment->status !== 'pending') disabled @endif>
          Setujui Jadwal
        </button>
      </div>

      @if($appointment->status !== 'pending')
        <div style="text-align:center;color:#6b7280;font-size:13px;margin-top:10px;">
          Jadwal sudah diproses.
        </div>
      @endif
    </form>
  </div>
@endsection
