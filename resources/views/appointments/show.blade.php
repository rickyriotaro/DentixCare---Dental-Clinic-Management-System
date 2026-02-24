@extends('layouts.admin')
@section('title','Kelola Janji Temu')

@section('content')
  <div class="page-title">Kelola Janji Temu</div>

  <div class="form-card" style="max-width:900px;">

    {{-- Tombol Kembali (baris sendiri) --}}
    <div style="margin-bottom:16px;">
      <a class="btn-ghost" href="{{ route('appointments.index') }}">← Kembali</a>
    </div>

    @if($appointment->status === 'pending')
    {{-- Form Penolakan (fullwidth, lebih besar) --}}
    <form method="POST" action="{{ route('appointments.reject', $appointment->id) }}" id="reject-form">
      @csrf
      <div style="background:#fff5f5;border:1.5px solid #fca5a5;border-radius:12px;padding:20px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
          <span style="font-size:18px;">🚫</span>
          <span style="font-weight:700;color:#dc2626;font-size:15px;">Tolak &amp; Informasikan ke Pasien</span>
        </div>
        <textarea name="alasan" rows="4"
          placeholder="Tulis alasan penolakan atau informasi untuk pasien... (wajib diisi)"
          style="width:100%;border:1.5px solid #fca5a5;border-radius:8px;padding:12px;font-size:14px;resize:vertical;line-height:1.6;color:#374151;outline:none;"
          required></textarea>
        <div style="margin-top:12px;">
          <button class="btn-danger" type="submit"
            onclick="return confirm('Yakin ingin menolak jadwal ini dan mengirim notifikasi ke pasien?')"
            style="padding:10px 24px;font-size:14px;">
            🚫 Tolak &amp; Kirim Notifikasi
          </button>
        </div>
      </div>
    </form>
    @endif

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
