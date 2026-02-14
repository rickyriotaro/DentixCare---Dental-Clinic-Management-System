@extends('layouts.dokter')
@section('title','Riwayat Perawatan')

@section('content')
<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
  <div>
    <h2 class="page-title" style="margin:0;color:var(--pink);font-weight:900;">Riwayat Perawatan</h2>
    <div style="color:#6b7280;margin-top:6px;">Daftar perawatan yang sudah pernah dilakukan</div>
  </div>

  <form method="GET" action="{{ route('dokter.riwayat.index') }}" style="display:flex;gap:10px;align-items:center;">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama / no rm / no hp..."
           style="width:320px;max-width:55vw;padding:10px 12px;border-radius:12px;border:1px solid #ffd0e6;outline:none;">
    <button class="btn-pink" type="submit" style="padding:10px 16px;border-radius:12px;">Cari</button>
  </form>
</div>

<div class="table-card" style="margin-top:14px;">
  <table class="table-pink">
    <thead>
      <tr>
        <th style="width:70px;">No</th>
        <th>Nama Pasien</th>
        <th style="width:120px;">No RM</th>
        <th style="width:140px;">Tanggal</th>
        <th>Keluhan</th>
        <th style="width:140px;">Dokter</th>
        <th style="width:90px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $i => $r)
        <tr>
          <td>{{ $records->firstItem() + $i }}</td>
          <td>{{ $r->patient->nama_lengkap ?? '-' }}</td>
          <td>{{ $r->no_rm ?? '-' }}</td>
          <td>{{ $r->tanggal_masuk ?? '-' }}</td>
          <td>{{ $r->keluhan ?? '-' }}</td>
          <td>{{ $r->dokter?->name ?? '-' }}</td>
          <td>
            <a class="link-pink" href="{{ route('dokter.riwayat.show', $r->id) }}">Detail</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:18px;color:#6b7280;">Belum ada riwayat perawatan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pager-wrap" style="margin-top:14px;">
  {{ $records->links('vendor.pagination.pink') }}
</div>
@endsection
