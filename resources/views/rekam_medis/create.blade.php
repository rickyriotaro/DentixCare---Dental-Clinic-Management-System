@extends('layouts.admin')
@section('title','Tambah Rekam Medis')

@section('content')
  <div class="page-title">TAMBAH DATA REKAM MEDIS</div>

  <div class="form-card" style="max-width:1000px;">

    <div style="margin-bottom:14px;">
      <a class="btn-ghost" href="{{ route('rekammedis.index') }}">Kembali</a>
    </div>

    @if ($errors->any())
      <div class="alert-error">Mohon lengkapi data dengan benar.</div>
    @endif

    <form method="POST" action="{{ route('rekammedis.store') }}">
      @csrf

      <div class="grid-2">
        <div class="form-row">
          <label>No.RM</label>
          <input class="form-input" value="Otomatis dibuat (5 digit)" readonly style="background-color: #f3f4f6; color: #6b7280;">
          <small style="color: #6b7280;">No.RM akan dibuat otomatis saat data disimpan</small>
        </div>

        <div class="form-row">
          <label>Tanggal Masuk</label>
          <input type="date" class="form-input" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
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
                    @selected(old('patient_id') == $p->id)>
              {{ $p->nama_lengkap }} ({{ $p->alamat ?? 'Alamat tidak tersedia' }})
            </option>
          @endforeach
        </select>
        @error('patient_id') <small class="err">{{ $message }}</small> @enderror
      </div>


      <div class="grid-2">
        <div class="form-row">
          <label>Keluhan</label>
          <input class="form-input" name="keluhan" value="{{ old('keluhan') }}">
          @error('keluhan') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
          <label>Alergi</label>
          <input class="form-input" name="alergi" id="alergi_input" value="{{ old('alergi') }}">
          <small style="color: #ec4899; font-size: 0.85rem;">
            <i class="fas fa-magic"></i> Otomatis terisi dari rekam medis terakhir
          </small>
          @error('alergi') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-row">
        <label>Riwayat Penyakit</label>
        <input class="form-input" name="riwayat_penyakit" id="riwayat_input" value="{{ old('riwayat_penyakit') }}">
        <small style="color: #ec4899; font-size: 0.85rem;">
          <i class="fas fa-magic"></i> Otomatis terisi dari rekam medis terakhir
        </small>
        @error('riwayat_penyakit') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-actions" style="justify-content:center;">
        <button class="btn-primary" type="submit" style="min-width:170px;">
          Simpan
        </button>
      </div>
    </form>


    <div style="margin-top:12px;color:#6b7280;font-size:13px;">
       <b></b> 
       
    </div>

  </div>

  <script>
    // Auto-fill Alergi & Riwayat Penyakit from latest medical record
    document.getElementById('patient_select').addEventListener('change', function() {
      const patientId = this.value;
      
      if (!patientId) {
        // Clear fields if no patient selected
        document.querySelector('input[name="alergi"]').value = '';
        document.querySelector('input[name="riwayat_penyakit"]').value = '';
        return;
      }

      // Show loading indicator
      const alergiInput = document.querySelector('input[name="alergi"]');
      const riwayatInput = document.querySelector('input[name="riwayat_penyakit"]');
      
      alergiInput.value = 'Memuat data...';
      riwayatInput.value = 'Memuat data...';
      alergiInput.disabled = true;
      riwayatInput.disabled = true;

      // Fetch latest medical record data
      fetch(`/api/rekam-medis/latest/${patientId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alergiInput.value = data.data.alergi || '';
            riwayatInput.value = data.data.riwayat_penyakit || '';
            
            // Show success message if data found
            if (data.data.alergi || data.data.riwayat_penyakit) {
              console.log('✅ Data rekam medis sebelumnya berhasil dimuat');
            }
          } else {
            // No previous data - clear fields
            alergiInput.value = '';
            riwayatInput.value = '';
            console.log('ℹ️ Tidak ada rekam medis sebelumnya');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alergiInput.value = '';
          riwayatInput.value = '';
        })
        .finally(() => {
          // Re-enable inputs
          alergiInput.disabled = false;
          riwayatInput.disabled = false;
        });
    });
  </script>
@endsection
