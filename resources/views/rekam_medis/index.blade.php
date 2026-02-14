@extends('layouts.admin')
@section('title','Data Rekam Medis')

@section('content')
  <div class="page-head">
    <div class="page-title">DATA REKAM MEDIS</div>
    <a class="btn-primary" href="{{ route('rekammedis.create') }}">Tambah Data</a>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>No.RM</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>Tanggal Masuk</th>
          <th>Keluhan</th>
          <th>Diagnosa</th>
          <th>Tindakan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $r)
          <tr>
            <td>{{ $r->no_rm }}</td>
            <td>{{ $r->patient->nama_lengkap ?? '-' }}</td>
            <td>{{ $r->patient->alamat ?? '-' }}</td>
            <td>{{ $r->tanggal_masuk }}</td>
            <td>{{ $r->keluhan ?? '-' }}</td>
            <td>{{ $r->diagnosa ?? '-' }}</td>
            <td>{{ $r->tindakan ?? '-' }}</td>
            <td class="aksi">
              <a class="link-action" href="{{ route('rekammedis.edit',$r->id) }}">Edit</a>
              <a class="link-action" href="{{ route('rekammedis.show',$r->id) }}">Detail</a>
              <form method="POST" action="{{ route('rekammedis.destroy',$r->id) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="link-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align:center;color:#6b7280;padding:18px;">
              Belum ada data rekam medis.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:16px;">
    {{ $records->links('vendor.pagination.pink') }}
  </div>
@endsection
