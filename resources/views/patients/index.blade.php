@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')
  <div class="page-head">
    <div class="page-title">DATA PASIEN</div>

    <a class="btn-primary" href="{{ route('patients.create') }}">
      Tambah Data
    </a>
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
          <th>Alamat</th>
          <th>No Hp</th>
          <th>Keluhan</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse($patients as $i => $p)
          <tr>
            <td>{{ $patients->firstItem() + $i }}</td>
            <td>{{ $p->nama_lengkap }}</td>
            <td>{{ $p->alamat }}</td>
            <td>{{ $p->no_hp }}</td>
            <td>{{ $p->keluhan }}</td>
            <td class="aksi">
              <a class="link-action" href="{{ route('patients.edit', $p->id) }}">Edit</a>
              <a class="link-action" href="{{ route('patients.show', $p->id) }}">Detail</a>

              <form method="POST" action="{{ route('patients.destroy', $p->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="link-danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center;color:#6b7280;padding:18px;">Belum ada data pasien.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:14px;">
   {{ $patients->links('vendor.pagination.pink') }}
  </div>
@endsection
