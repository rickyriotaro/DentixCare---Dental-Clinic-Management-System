@extends('layouts.admin')
@section('title', 'Edit Pasien')

@section('content')
  <div class="page-title">EDIT DATA PASIEN</div>

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

    <form method="POST" action="{{ route('patients.update', $patient->id) }}">
      @csrf
      @method('PUT')

      <div class="form-row">
        <label>Nama Pasien</label>
        <input class="form-input" name="nama_lengkap" value="{{ old('nama_lengkap', $patient->nama_lengkap) }}" required>
      </div>

      <div class="form-row">
        <label>Email</label>
        <input class="form-input" type="email" name="email" value="{{ old('email', $patient->email) }}" required>
        @error('email') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Username</label>
        <input class="form-input" name="username" value="{{ old('username', $patient->username) }}" required>
        @error('username') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Password (Kosongkan jika tidak ingin diubah)</label>
        <input class="form-input" type="password" name="password">
        @error('password') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Alamat</label>
        <input class="form-input" name="alamat" value="{{ old('alamat', $patient->alamat) }}">
      </div>

      <div class="form-row">
        <label>No HP</label>
        <input class="form-input" name="no_hp" value="{{ old('no_hp', $patient->no_hp) }}">
      </div>

      <div class="form-row">
        <label>Keluhan</label>
        <input class="form-input" name="keluhan" value="{{ old('keluhan', $patient->keluhan) }}">
      </div>

      <div class="form-actions">
        <a class="btn-ghost" href="{{ route('patients.index') }}">Kembali</a>
        <button class="btn-primary" type="submit">Update</button>
      </div>
    </form>
  </div>
@endsection
