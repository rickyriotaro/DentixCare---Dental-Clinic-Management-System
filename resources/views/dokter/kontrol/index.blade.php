@extends('layouts.dokter')
@section('title','Kontrol Pasien')

@section('content')
<div class="page-header">
  <h2 class="page-title" style="color:var(--pink);font-weight:900;">Kontrol Pasien</h2>
  <div style="color:#6b7280;margin-top:6px;">Pilih pasien untuk dijadwalkan kontrol.</div>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
  <table class="table-pink">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>No RM</th>
        <th>Perawatan Terakhir (Diagnosa/Tindakan)</th>
        <th>Kontrol Terakhir</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $i => $r)
        @php $last = $r->controls->first(); @endphp
        <tr>
          <td>{{ ($records->currentPage()-1)*$records->perPage() + $i + 1 }}</td>
          <td>{{ $r->patient->nama_lengkap ?? '-' }}</td>
          <td>{{ $r->no_rm ?? '-' }}</td>
          <td>
            <div><b>Diagnosa:</b> {{ $r->diagnosa ?? '-' }}</div>
            <div><b>Tindakan:</b> {{ $r->tindakan ?? '-' }}</div>
          </td>
          <td>
            @if($last)
              <div>{{ $last->tanggal_kontrol }} {{ $last->jam_kontrol ? '• '.$last->jam_kontrol : '' }}</div>
              <div style="color:#6b7280;font-size:13px;">{{ $last->status }}</div>
            @else
              <span style="color:#6b7280;">Belum ada</span>
            @endif
          </td>
          <td style="white-space:nowrap;">
            <a class="link-pink" href="{{ route('dokter.kontrol.show', $r->id) }}">Detail</a>
            <span style="margin:0 6px;color:#e5e7eb;">|</span>
            <a class="link-pink" href="{{ route('dokter.kontrol.create', $r->id) }}">Jadwalkan</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;padding:16px;">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pager-wrap">
  {{ $records->links('vendor.pagination.pink') }}
</div>
@endsection
