@extends('layouts.admin')
@section('title','Laporan Keuangan')

@section('content')
  <div class="page-header">
    <h2 class="page-title">Laporan Keuangan</h2>

    <div class="report-actions">
      <button type="button" class="btn-ghost" onclick="window.print()">Print</button>

      <a class="btn-primary"
         href="{{ route('reports.finance.download', request()->query()) }}">
        Simpan Laporan
      </a>
    </div>
  </div>

  <div class="report-card">
    <form method="GET" action="{{ route('reports.finance.index') }}" class="report-filter">
      <div class="rf-grid">
        <div class="rf-row">
          <label>Jenis Laporan</label>
          <select name="jenis" class="form-input">
            <option value="semua" {{ $jenis=='semua'?'selected':'' }}>Semua</option>
            <option value="pemasukan" {{ $jenis=='pemasukan'?'selected':'' }}>Pemasukan</option>
            <option value="pengeluaran" {{ $jenis=='pengeluaran'?'selected':'' }}>Pengeluaran</option>
          </select>
        </div>

        <div class="rf-row">
          <label>Dari Tanggal</label>
          <input type="date" name="from" class="form-input" value="{{ $from }}">
        </div>

        <div class="rf-row">
          <label>Sampai Tanggal</label>
          <input type="date" name="to" class="form-input" value="{{ $to }}">
        </div>

        <div class="rf-row">
          <label>Kata Kunci</label>
          <input type="text" name="q" class="form-input" value="{{ $q }}" placeholder="kategori / deskripsi">
        </div>
      </div>

      <div class="rf-actions">
        <button class="btn-primary" type="submit">Tampilkan Laporan</button>
        <a class="btn-ghost" href="{{ route('reports.finance.index') }}">Reset</a>
      </div>
    </form>
  </div>

  {{-- Ringkasan --}}
  <div class="finance-summary">
    <div class="fs-card">
      <div class="fs-label">Total Pemasukan</div>
      <div class="fs-val">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
    </div>
    <div class="fs-card">
      <div class="fs-label">Total Pengeluaran</div>
      <div class="fs-val">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
    </div>
    <div class="fs-card">
      <div class="fs-label">Saldo</div>
      <div class="fs-val">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
    </div>
  </div>

  {{-- Tabel --}}
  <div class="table-card">
    <table class="table-pink">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Jenis</th>
          <th>Kategori</th>
          <th>Deskripsi</th>
          <th style="text-align:right;">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $r)
          <tr>
            <td>{{ $r->tanggal }}</td>
            <td style="text-transform:capitalize;">{{ $r->jenis }}</td>
            <td>{{ $r->kategori ?? '-' }}</td>
            <td>{{ $r->deskripsi ?? '-' }}</td>
            <td style="text-align:right;">Rp {{ number_format($r->jumlah, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="text-align:center; padding:18px;">Data tidak ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pager-wrap">
    {{ $records->onEachSide(0)->links('vendor.pagination.pink') }}
  </div>
@endsection
