@extends('layouts.admin')

@section('title', 'Tambah Pasien')

@section('content')
  <div class="page-title">TAMBAH DATA PASIEN</div>

  <div class="form-card">

    {{-- Alert error umum --}}
    @if ($errors->any())
      <div class="alert-error" style="margin-bottom: 20px;">
        <strong>Gagal menyimpan data!</strong>
        <ul style="margin: 10px 0 0 20px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('patients.store') }}">
      @csrf

      <div class="form-row">
        <label>Nama Lengkap</label>
        <input class="form-input" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        @error('nama_lengkap') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Email</label>
        <input class="form-input" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Username</label>
        <input class="form-input" name="username" value="{{ old('username') }}" required>
        @error('username') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Password</label>
        <input class="form-input" type="password" name="password" required>
        @error('password') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Alamat</label>
        <input class="form-input" name="alamat" value="{{ old('alamat') }}">
      </div>

      <div class="form-row">
        <label>No HP</label>
        <input class="form-input" name="no_hp" value="{{ old('no_hp') }}">
      </div>

      <div class="form-row">
        <label>Keluhan</label>
        <input class="form-input" name="keluhan" value="{{ old('keluhan') }}">
      </div>

      <div class="form-actions">
        <a class="btn-ghost" href="{{ route('patients.index') }}">Kembali</a>
        <button class="btn-primary" type="submit">Simpan</button>
      </div>
    </form>
  </div>
@endsection
