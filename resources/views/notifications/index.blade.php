@extends('layouts.admin')

@section('content')
<div class="page-header">
  <h2 class="page-title">Pemberitahuan</h2>

  <a href="{{ route('notifications.create') }}" class="btn-primary">
    + Kirim Pemberitahuan
  </a>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
  <table class="table-pink">
    <thead>
      <tr>
        <th>Pasien</th>
        <th>No HP</th>
        <th>Jenis</th>
        <th>Judul</th>
        <th>Status</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @forelse($notifications as $n)
      <tr>
        <td>{{ $n->patient->nama_lengkap ?? '-' }}</td>
        <td>{{ $n->no_hp ?? '-' }}</td>
        <td>{{ ucfirst($n->jenis) }}</td>
        <td>{{ $n->judul }}</td>
        <td>
          <span class="badge pink">{{ $n->status }}</span>
        </td>
        <td>{{ $n->created_at->format('d/m/Y') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; padding:18px;">Belum ada pemberitahuan.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pager-wrap">
  {{ $notifications->onEachSide(0)->links('vendor.pagination.pink') }}
</div>
@endsection
