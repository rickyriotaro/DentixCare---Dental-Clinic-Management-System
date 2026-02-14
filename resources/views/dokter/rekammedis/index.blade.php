@extends('layouts.dokter')
@section('title','Rekam Medis')

@section('content')
  <div class="page-head">
    <div class="page-title" style="color:var(--pink);font-weight:900;">
      Data Rekam Medis
    </div>
  </div>

  <div class="table-wrap" style="margin-top:14px;">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>No RM</th>
          <th>Tanggal Masuk</th>
          <th>Keluhan</th>
          <th>Status Isi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $i => $r)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $r->patient->nama_lengkap ?? '-' }}</td>
            <td>{{ $r->no_rm ?? '-' }}</td>
            <td>{{ $r->tanggal_masuk ?? '-' }}</td>
            <td>{{ $r->keluhan ?? '-' }}</td>
            <td>
              @if($r->diagnosa || $r->tindakan || $r->resep_obat)
                <span class="badge success">SUDAH DIISI</span>
              @else
                <span class="badge warning">BELUM</span>
              @endif
            </td>
            <td style="display:flex;gap:10px;align-items:center;">
              <a class="link" href="{{ route('dokter.rekammedis.show', $r->id) }}">Detail</a>
              <a class="link" href="{{ route('dokter.rekammedis.input', $r->id) }}">Input</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;color:#6b7280;padding:18px;">
              Belum ada data.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
