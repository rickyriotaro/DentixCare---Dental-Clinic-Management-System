@extends('layouts.dokter')
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
          <td>{{ $appointments->firstItem() + $i }}</td>
          <td>{{ $a->patient?->nama_lengkap ?? '-' }}</td>
          <td>{{ $a->tanggal_diminta }}</td>
          <td>{{ $a->jam_diminta }}</td>
          <td>
            <span class="badge success">APPROVED</span>
          </td>
          <td>
            <a href="{{ route('dokter.appointments.show', $a->id) }}" class="link">Detail</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;color:#6b7280;padding:18px;">
            Belum ada jadwal yang sudah disetujui.
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
