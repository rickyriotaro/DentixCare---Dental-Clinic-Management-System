@extends('layouts.admin')

@section('title', 'Pendaftaran Pasien')

@section('content')
  <div class="page-title">Pendaftaran Pasien</div>

  <div class="form-card" style="max-width:900px;">

    <div style="margin-bottom:14px;">
      <a class="btn-ghost" href="{{ route('dashboard') }}">Kembali</a>
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}

        <div style="margin-top:10px;">
          <a class="btn-primary" href="{{ route('patients.index') }}" style="padding:8px 12px;">
            Lihat Data Pasien
          </a>
        </div>
      </div>
    @endif

    {{-- Alert error umum --}}
    @if ($errors->any())
      <div class="alert-error">
        Gagal menyimpan. Pastikan data wajib sudah diisi dengan benar.
      </div>
    @endif

    <form method="POST" action="{{ route('pendaftaran.store') }}">
      @csrf

      <div class="form-row">
        <label>Nama Lengkap</label>
        <input class="form-input" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        @error('nama_lengkap')
          <small class="err">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-row">
        <label>Alamat</label>
        <input class="form-input" name="alamat" value="{{ old('alamat') }}">
        @error('alamat')
          <small class="err">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-row">
        <label>No Hp</label>
        <input class="form-input" name="no_hp" value="{{ old('no_hp') }}">
        @error('no_hp')
          <small class="err">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-row">
        <label>Keluhan</label>
        <input class="form-input" name="keluhan" value="{{ old('keluhan') }}">
        @error('keluhan')
          <small class="err">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:140px;">
          Simpan
        </button>
      </div>
    </form>

  </div>
@endsection
