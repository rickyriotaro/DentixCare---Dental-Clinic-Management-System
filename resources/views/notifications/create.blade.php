@extends('layouts.admin')
@section('title','Kirim Pemberitahuan')

@section('content')
  <div class="page-title">Kirim Pemberitahuan</div>

  <div class="form-card notify-card" style="max-width:1000px;">
    <div style="margin-bottom:14px;">
      <a class="btn-ghost" href="{{ route('notifications.index') }}">Kembali</a>
    </div>

    @if ($errors->any())
      <div class="alert-error">Mohon lengkapi data dengan benar.</div>
    @endif

    <form method="POST" action="{{ route('notifications.store') }}">
      @csrf

      <div class="notify-grid">
        <div class="notify-row">
          <label>Jenis Pemberitahuan</label>
          <select name="jenis" class="form-input" required>
            <option value="">-- Pilih --</option>
            <option value="jadwal" @selected(old('jenis')=='jadwal')>Jadwal Janji Temu</option>
            <option value="perubahan" @selected(old('jenis')=='perubahan')>Perubahan Jadwal</option>
            <option value="kontrol" @selected(old('jenis')=='kontrol')>Kontrol Ulang</option>
            <option value="obat" @selected(old('jenis')=='obat')>Obat</option>
          </select>
          @error('jenis') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="notify-row">
          <label>Pasien</label>
          <select name="patient_id" id="patient_select" class="form-input" required>
            <option value="">-- Pilih Pasien --</option>
            @foreach($patients as $p)
              <option value="{{ $p->id }}"
                      data-nohp="{{ $p->no_hp ?? '' }}"
                      @selected(old('patient_id')==$p->id)>
                {{ $p->id }} - {{ $p->nama_lengkap }}
              </option>
            @endforeach
          </select>
          @error('patient_id') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="notify-row">
          <label>No HP Pasien</label>
          <input name="no_hp" id="no_hp_field" class="form-input" value="{{ old('no_hp') }}" readonly style="background-color: #f3f4f6;">
          @error('no_hp') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="notify-row notify-full">
          <label>Judul</label>
          <input name="judul" class="form-input"value="{{ old('judul') }}" placeholder="Contoh: Jadwal Janji Temu Disetujui"required>
          @error('judul') <small class="err">{{ $message }}</small> @enderror
        </div>

        <div class="notify-row notify-full">
          <label>Pesan</label>
          <textarea name="pesan" class="form-input notify-textarea" rows="4"placeholder="Tulis pesan pemberitahuan untuk pasien..."required>{{ old('pesan') }}</textarea>
          @error('pesan') <small class="err">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-actions notify-actions">
        <button class="btn-primary" type="submit" style="min-width:160px;">Kirim</button>
      </div>
    </form>

    <script>
      // Auto-fill no hp saat pasien dipilih
      document.getElementById('patient_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const noHp = selectedOption.getAttribute('data-nohp');
        document.getElementById('no_hp_field').value = noHp || '';
      });
    </script>
  </div>
@endsection
