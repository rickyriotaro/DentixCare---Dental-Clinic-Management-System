@extends('layouts.admin')
@section('title','Laporan Kunjungan')

@section('content')
  <div class="page-header">
    <h2 class="page-title">Laporan Kunjungan</h2>

    <div class="report-actions">
      <button type="button" class="btn-ghost" onclick="window.print()">Print</button>

      {{-- Simpan laporan (POST) --}}
      <form method="POST" action="{{ route('reports.visits.save') }}">
        @csrf
        <input type="hidden" name="from" value="{{ $filters['from'] ?? '' }}">
        <input type="hidden" name="to" value="{{ $filters['to'] ?? '' }}">
        <input type="hidden" name="nama" value="{{ $filters['nama'] ?? '' }}">

        <button class="btn-primary" type="submit">Simpan Laporan</button>
      </form>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert-danger">{{ session('error') }}</div>
  @endif

  <div class="report-card">
    {{-- Filter (GET) --}}
    <form method="GET" action="{{ route('reports.visits.index') }}" class="report-filter">
      <div class="rf-grid">
        <div class="rf-row">
          <label>Dari Tanggal</label>
          <input type="date" name="from" class="form-input" value="{{ $filters['from'] ?? '' }}">
        </div>

        <div class="rf-row">
          <label>Sampai Tanggal</label>
          <input type="date" name="to" class="form-input" value="{{ $filters['to'] ?? '' }}">
        </div>

        <div class="rf-row">
          <label>Nama Pasien</label>
          <input type="text" name="nama" class="form-input" value="{{ $filters['nama'] ?? '' }}" placeholder="Cari nama pasien...">
        </div>
      </div>

      <div class="rf-actions">
        <button class="btn-primary" type="submit">Tampilkan hasil laporan</button>
        <a class="btn-ghost" href="{{ route('reports.visits.index') }}">Reset</a>
      </div>
    </form>
  </div>

  {{-- Tabel hasil --}}
  <div class="table-card">
    <table class="table-pink">
      <thead>
        <tr>
          <th>No.RM</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>Tanggal Masuk</th>
          <th>Keluhan</th>
          <th>Alergi</th>
          <th>Riwayat Penyakit</th>
          <th>Rencana Perawatan</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $r)
          <tr>
            <td>{{ $r->no_rm ?? '-' }}</td>
            <td>{{ $r->patient?->nama_lengkap ?? '-' }}</td>
            <td>{{ $r->patient?->alamat ?? '-' }}</td>
            <td>{{ $r->tanggal_masuk ?? '-' }}</td>
            <td>{{ $r->keluhan ?? '-' }}</td>
            <td>{{ $r->alergi ?? '-' }}</td>
            <td>{{ $r->riwayat_penyakit ?? '-' }}</td>
            {{-- kalau rencana perawatan kamu simpan di tabel lain/kolom lain, ganti ini --}}
            <td>{{ $r->tindakan ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align:center; padding:18px;">Data tidak ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pager-wrap">
   {{ $records->onEachSide(0)->links('vendor.pagination.pink') }}
  </div>
@endsection
