@extends('layouts.admin')
@section('title','Jadwal Janji Temu')

@section('content')
  <div class="page-head">
    <div class="page-title">JADWAL JANJI TEMU</div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>Tanggal Diminta</th>
          <th>Jam Diminta</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($appointments as $i => $a)
    <tr>
      <td>{{ $i + 1 }}</td>

      <td>{{ $a->patient?->nama_lengkap ?? '-' }}</td>
      <td>{{ $a->tanggal_diminta }}</td>
      <td>{{ $a->jam_diminta }}</td>

      <td>
        @if ($a->status === 'approved')
          <span class="badge success">APPROVED</span>
        @elseif ($a->status === 'pending')
          <span class="badge warning">PENDING</span>
        @else
          <span class="badge danger">REJECTED</span>
        @endif
      </td>

      <td>
        <a href="{{ route('appointments.show', $a->id) }}" class="link">Kelola</a>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="6" style="text-align:center;color:#6b7280;padding:18px;">
        Belum ada permintaan janji temu.
      </td>
    </tr>
  @endforelse
</tbody>
    </table>
  </div>

  <div style="margin-top:16px;">
    {{ $appointments->links('vendor.pagination.pink') }}
  </div>
@endsection
