@extends('layouts.admin')
@section('title','Jadwal Libur Dokter')

@section('content')
  <div class="page-title">📅 Jadwal Libur Dokter</div>

  <div class="form-card" style="max-width:900px;">

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="alert-success" style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert-error" style="background:#fff5f5;border:1px solid #fca5a5;color:#dc2626;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    {{-- Form Tambah Jadwal Libur --}}
    <form method="POST" action="{{ route('jadwal-libur.store') }}">
      @csrf
      <div style="background:#fef3c7;border:1.5px solid #fbbf24;border-radius:12px;padding:20px;margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
          <span style="font-size:20px;">➕</span>
          <span style="font-weight:700;color:#92400e;font-size:15px;">Tambah Jadwal Libur Baru</span>
        </div>
        <div class="grid-2" style="gap:16px;">
          <div class="form-row">
            <label>Tanggal Libur</label>
            <input type="date" class="form-input" name="tanggal" value="{{ old('tanggal') }}" required
                   min="{{ date('Y-m-d') }}">
          </div>
          <div class="form-row">
            <label>Keterangan (opsional)</label>
            <input type="text" class="form-input" name="keterangan" value="{{ old('keterangan') }}"
                   placeholder="Contoh: Libur Hari Raya, Dokter Cuti, dll">
          </div>
        </div>
        <div style="margin-top:14px;">
          <button class="btn-primary" type="submit" style="padding:10px 24px;">
            📢 Simpan & Kirim Notifikasi ke Semua Pasien
          </button>
        </div>
        <div style="margin-top:8px;font-size:12px;color:#92400e;">
          ⚠️ Menyimpan jadwal libur akan otomatis mengirim notifikasi ke semua pasien terdaftar.
        </div>
      </div>
    </form>

    {{-- Tabel Daftar Jadwal Libur --}}
    <div class="sub-title">Daftar Jadwal Libur</div>

    @if($schedules->isEmpty())
      <div style="text-align:center;padding:40px 20px;color:#9ca3af;">
        <div style="font-size:48px;margin-bottom:12px;">📅</div>
        <div style="font-size:15px;">Belum ada jadwal libur yang ditambahkan.</div>
      </div>
    @else
      <div style="overflow-x:auto;">
        <table class="data-table" style="width:100%;">
          <thead>
            <tr>
              <th style="width:50px;">No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th style="width:100px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($schedules as $i => $schedule)
              <tr>
                <td>{{ $schedules->firstItem() + $i }}</td>
                <td>
                  <span style="font-weight:600;">
                    {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                  </span>
                  @if(\Carbon\Carbon::parse($schedule->tanggal)->isFuture())
                    <span style="background:#dcfce7;color:#16a34a;font-size:11px;padding:2px 8px;border-radius:10px;margin-left:6px;">Mendatang</span>
                  @else
                    <span style="background:#f3f4f6;color:#9ca3af;font-size:11px;padding:2px 8px;border-radius:10px;margin-left:6px;">Lewat</span>
                  @endif
                </td>
                <td>{{ $schedule->keterangan ?? '-' }}</td>
                <td>
                  <form method="POST" action="{{ route('jadwal-libur.destroy', $schedule->id) }}"
                        style="display:inline;" onsubmit="return confirm('Hapus jadwal libur ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" style="padding:6px 12px;font-size:12px;">
                      🗑 Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div style="margin-top:16px;">
        {{ $schedules->links() }}
      </div>
    @endif
  </div>
@endsection
