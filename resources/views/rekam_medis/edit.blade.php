@extends('layouts.admin')
@section('title','Edit Rekam Medis')

@section('content')
  <div class="page-title">EDIT DATA REKAM MEDIS</div>

  <div class="form-card" style="max-width:1000px;">

    <div style="margin-bottom:14px; display:flex; gap:10px;">
      <a class="btn-ghost" href="{{ route('rekammedis.index') }}">Kembali</a>
      <a class="btn-ghost" href="{{ route('rekammedis.show', $medicalRecord->id) }}">Detail</a>
    </div>

    @if ($errors->any())
      <div class="alert-error">Mohon lengkapi data dengan benar.</div>
    @endif

    <form method="POST" action="{{ route('rekammedis.update', $medicalRecord->id) }}">
      @csrf
      @method('PUT')

      <div class="grid-2">
        <div class="form-row">
          <label>No.RM</label>
          <input class="form-input" value="{{ $medicalRecord->no_rm }}" disabled>
          <small style="color:#6b7280;">No.RM tidak bisa diubah.</small>
        </div>

        <div class="form-row">
          <label>Tanggal Masuk</label>
          <input type="date" class="form-input" name="tanggal_masuk"
                 value="{{ old('tanggal_masuk', $medicalRecord->tanggal_masuk) }}" required>
          @error('tanggal_masuk') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-row">
        <label>Pilih Pasien</label>
        <select class="form-input" id="patient_select" name="patient_id" required>
          <option value="">-- Pilih Pasien --</option>
          @foreach($patients as $p)
            <option value="{{ $p->id }}"
                    data-nama="{{ $p->nama_lengkap }}"
                    data-alamat="{{ $p->alamat ?? '' }}"
                    @selected(old('patient_id', $medicalRecord->patient_id) == $p->id)>
              {{ $p->id }} - {{ $p->nama_lengkap }}
            </option>
          @endforeach
        </select>
        @error('patient_id') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="grid-2">
        <div class="form-row">
          <label>Nama Pasien</label>
          <input class="form-input" id="nama_pasien_field" name="nama_pasien_display"
                 value="{{ old('nama_pasien_display', $medicalRecord->patient->nama_lengkap ?? '') }}"
                 readonly style="background-color: #f3f4f6;">
        </div>

        <div class="form-row">
          <label>Alamat</label>
          <input class="form-input" id="alamat_field" name="alamat_display"
                 value="{{ old('alamat_display', $medicalRecord->patient->alamat ?? '') }}"
                 readonly style="background-color: #f3f4f6;">
        </div>
      </div>

      <div class="grid-2">
        <div class="form-row">
          <label>Keluhan</label>
          <input class="form-input" name="keluhan"
                 value="{{ old('keluhan', $medicalRecord->keluhan) }}">
          @error('keluhan') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
          <label>Alergi</label>
          <input class="form-input" name="alergi"
                 value="{{ old('alergi', $medicalRecord->alergi) }}">
          @error('alergi') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-row">
        <label>Riwayat Penyakit</label>
        <input class="form-input" name="riwayat_penyakit"
               value="{{ old('riwayat_penyakit', $medicalRecord->riwayat_penyakit) }}">
        @error('riwayat_penyakit') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:170px;">
          Update
        </button>
      </div>
    </form>

    <script>
      // Auto-fill nama dan alamat saat pasien dipilih
      document.getElementById('patient_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const namaPasien = selectedOption.getAttribute('data-nama');
        const alamat = selectedOption.getAttribute('data-alamat');

        document.getElementById('nama_pasien_field').value = namaPasien || '';
        document.getElementById('alamat_field').value = alamat || '';
      });
    </script>

  </div>
@endsection
