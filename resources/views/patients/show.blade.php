@extends('layouts.admin')
@section('title', 'Detail Pasien')

@section('content')
  <div class="page-head">
    <div class="page-title">DETAIL PASIEN</div>
    <div>
      <a class="btn-ghost" href="{{ route('patients.index') }}">Kembali</a>
      <a class="btn-primary" href="{{ route('patients.edit', $patient->id) }}">Edit Data</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="form-card" style="max-width:1000px;">
    <div class="sub-title">Informasi Pasien</div>
    <div class="detail-box">
      <div><b>Nama Lengkap:</b> {{ $patient->nama_lengkap }}</div>
      <div><b>Email:</b> {{ $patient->email ?? '-' }}</div>
      <div><b>No. HP:</b> {{ $patient->no_hp }}</div>
      <div><b>Alamat:</b> {{ $patient->alamat ?? '-' }}</div>
      <div><b>Keluhan Terakhir:</b> {{ $patient->keluhan ?? '-' }}</div>
      <div><b>Terdaftar Sejak:</b> {{ $patient->created_at->format('d F Y') }}</div>
    </div>
  </div>

  <!--{{-- Statistics --}}
  <div class="form-card" style="max-width:1000px;">
    <div class="sub-title">Statistik</div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
      <div class="stat-box">
        <div class="stat-number">{{ $patient->appointments_count ?? 0 }}</div>
        <div class="stat-label">Janji Temu</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">{{ $patient->medical_records_count ?? 0 }}</div>
        <div class="stat-label">Rekam Medis</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">{{ $patient->treatment_plans_count ?? 0 }}</div>
        <div class="stat-label">Rencana Perawatan</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">{{ $controlsCount ?? 0 }}</div>
        <div class="stat-label">Jadwal Kontrol</div>
      </div>
    </div>
  </div>

  {{-- Janji Temu Terbaru --}}
  @if($latestAppointments->count() > 0)
  <div class="table-card">
    <div class="sub-title">Janji Temu Terbaru</div>
    <table class="table-pink">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Jam</th>
          <th>Dokter</th>
          <th>Keluhan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($latestAppointments as $apt)
        <tr>
          <td>{{ \Carbon\Carbon::parse($apt->tanggal_janji)->format('d M Y') }}</td>
          <td>{{ $apt->jam_janji ?? '-' }}</td>
          <td>{{ $apt->dokter->name ?? '-' }}</td>
          <td>{{ Str::limit($apt->keluhan, 50) }}</td>
          <td>
            <span class="badge badge-{{ $apt->status == 'approved' ? 'success' : ($apt->status == 'pending' ? 'warning' : 'danger') }}">
              {{ ucfirst($apt->status) }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Rekam Medis Terbaru --}}
  @if($latestMedicalRecords->count() > 0)
  <div class="table-card">
    <div class="sub-title">Rekam Medis Terbaru</div>
    <table class="table-pink">
      <thead>
        <tr>
          <th>No. RM</th>
          <th>Tanggal</th>
          <th>Keluhan</th>
          <th>Diagnosa</th>
          <th>Tindakan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($latestMedicalRecords as $rm)
        <tr>
          <td><strong style="color: #ec4899;">{{ $rm->no_rm }}</strong></td>
          <td>{{ $rm->tanggal_masuk }}</td>
          <td>{{ Str::limit($rm->keluhan, 30) ?? '-' }}</td>
          <td>{{ Str::limit($rm->diagnosa, 40) ?? '-' }}</td>
          <td>{{ Str::limit($rm->tindakan, 40) ?? '-' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif-->

@endsection

<style>
.stat-box {
  background: linear-gradient(135deg, #fdf2f8, #fce7f3);
  border: 2px solid #ec4899;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
}

.stat-number {
  font-size: 32px;
  font-weight: 700;
  color: #ec4899;
  margin-bottom: 8px;
}

.stat-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 500;
}

.badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
  display: inline-block;
}

.badge-success {
  background: #d1fae5;
  color: #065f46;
}

.badge-warning {
  background: #fef3c7;
  color: #92400e;
}

.badge-danger {
  background: #fee2e2;
  color: #991b1b;
}

@media (max-width: 768px) {
  .form-card div[style*="grid-template-columns"] {
    grid-template-columns: repeat(2, 1fr) !important;
  }
}
</style>
