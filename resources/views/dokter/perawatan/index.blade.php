@extends('layouts.dokter')
@section('title','Rencana Perawatan Gigi')

@section('content')
<div class="page-head" style="display:flex;justify-content:space-between;align-items:center;">
  <div>
    <div class="page-title" style="color:var(--pink);font-weight:900;">Rencana Perawatan Gigi</div>
    <div style="color:#6b7280;margin-top:6px;">Pilih pasien dari daftar rekam medis</div>
  </div>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap" style="margin-top:14px;">
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>No RM</th>
        <th>Tanggal Masuk</th>
        <th>Keluhan</th>
        <th>Aksi</th>
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
          <td>
            <a class="link" href="{{ route('dokter.perawatan.show', $r->id) }}">Detail</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:18px;">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:16px;">
  {{ $records->links('vendor.pagination.pink') }}
</div>
@endsection
