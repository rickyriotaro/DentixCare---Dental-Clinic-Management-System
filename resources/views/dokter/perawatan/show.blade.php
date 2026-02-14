@extends('layouts.dokter')
@section('title','Detail Rencana Perawatan')

@section('content')
<div class="page-head" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">Detail Rekam Medis & Rencana Perawatan</div>
    <div style="color:#6b7280;margin-top:6px;">
      {{ $medicalRecord->patient->nama_lengkap ?? '-' }}
      • {{ $medicalRecord->patient?->no_hp ?? '-' }}
      • {{ $medicalRecord->patient->alamat ?? '-' }}
    </div>
  </div>

  <div style="display:flex;gap:10px;">
    <a class="btn-ghost" href="{{ route('dokter.perawatan.index') }}">Kembali</a>
    <a class="btn" href="{{ route('dokter.perawatan.create', $medicalRecord->id) }}" style="width:auto;padding:10px 16px;">
      + Buat Rencana Perawatan
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap" style="margin-top:14px;">
  <table class="table">
    <tbody>
      <tr><th style="width:220px;">No RM</th><td>{{ $medicalRecord->no_rm ?? '-' }}</td></tr>
      <tr><th>Tanggal Masuk</th><td>{{ $medicalRecord->tanggal_masuk ?? '-' }}</td></tr>
      <tr><th>Keluhan</th><td>{{ $medicalRecord->keluhan ?? '-' }}</td></tr>
      <tr><th>Diagnosa</th><td>{{ $medicalRecord->diagnosa ?? '-' }}</td></tr>
      <tr><th>Tindakan</th><td>{{ $medicalRecord->tindakan ?? '-' }}</td></tr>
    </tbody>
  </table>
</div>

<div class="page-title" style="margin-top:18px;color:var(--pink);font-weight:900;">Daftar Rencana Perawatan</div>

<div class="table-wrap" style="margin-top:10px;">
  <table class="table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Judul</th>
        <th>Rencana</th>
        <th>Status</th>
        <th>Dokter</th>
        <th style="width:150px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($plans as $p)
        <tr>
          <td>{{ $p->tanggal_rencana ?? '-' }}</td>
          <td>{{ $p->judul ?? '-' }}</td>
          <td>{{ \Illuminate\Support\Str::limit($p->rencana, 80) }}</td>
          <td>
            @if($p->status === 'selesai')
              <span class="badge success">SELESAI</span>
            @else
              <span class="badge warning">DRAFT</span>
            @endif
          </td>
          <td>{{ $p->dokter?->name ?? '-' }}</td>
          <td>
            @if($p->status === 'draft')
              <form method="POST" action="{{ route('dokter.perawatan.complete', $p->id) }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-sm" style="background:#10b981;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:13px;" 
                        onclick="return confirm('Tandai rencana ini sebagai selesai?')">
                  ✓ Selesai
                </button>
              </form>
            @else
              <span style="color:#10b981;font-size:13px;font-weight:600;">✓ Completed</span>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:18px;">Belum ada rencana perawatan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
