@extends('layouts.admin')
@section('title', 'Detail Pasien')

@section('content')
  <div class="page-title">DETAIL PASIEN</div>

  {{-- Patient Info Card --}}
  <div class="form-card" style="max-width: 100%; margin-bottom: 30px;">
    <div style="background: linear-gradient(135deg, #ff2d8d 0%, #ff73bc 100%); color: white; padding: 25px; border-radius: 12px; margin: -18px -18px 20px -18px; position: relative; overflow: hidden;">
      <div style="position: absolute; top: -50%; right: -10%; width: 250px; height: 250px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
      <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 20px;">
        <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; border: 2px solid rgba(255, 255, 255, 0.3);">
          <i class="fas fa-user-circle"></i>
        </div>
        <div>
          <h2 style="margin: 0 0 5px 0; font-size: 22px; font-weight: 700;">{{ $patient->nama_lengkap }}</h2>
          <p style="margin: 0; font-size: 13px; opacity: 0.9;">
            <i class="fas fa-calendar-plus"></i> Terdaftar sejak {{ $patient->created_at->format('d F Y') }}
          </p>
        </div>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
      <div style="padding: 18px; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%); border-radius: 12px; border: 1px solid rgba(255,45,141,0.1); display: flex; gap: 12px; align-items: flex-start;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff2d8d, #ff73bc); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
          <i class="fas fa-envelope"></i>
        </div>
        <div>
          <div style="Font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Email</div>
          <div style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $patient->email ?? '-' }}</div>
        </div>
      </div>

      <div style="padding: 18px; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%); border-radius: 12px; border: 1px solid rgba(255,45,141,0.1); display: flex; gap: 12px; align-items: flex-start;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff2d8d, #ff73bc); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
          <i class="fas fa-phone"></i>
        </div>
        <div>
          <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">No. HP</div>
          <div style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $patient->no_hp }}</div>
        </div>
      </div>

      <div style="grid-column: 1 / -1; padding: 18px; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%); border-radius: 12px; border: 1px solid rgba(255,45,141,0.1); display: flex; gap: 12px; align-items: flex-start;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff2d8d, #ff73bc); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <div>
          <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Alamat</div>
          <div style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $patient->alamat ?? '-' }}</div>
        </div>
      </div>

      <div style="grid-column: 1 / -1; padding: 18px; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%); border-radius: 12px; border: 1px solid rgba(255,45,141,0.1); display: flex; gap: 12px; align-items: flex-start;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff2d8d, #ff73bc); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
          <i class="fas fa-notes-medical"></i>
        </div>
        <div>
          <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Keluhan</div>
          <div style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $patient->keluhan ?? '-' }}</div>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a class="btn-ghost" href="{{ route('patients.index') }}">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
      <a class="btn-primary" href="{{ route('patients.edit', $patient->id) }}">
        <i class="fas fa-edit"></i> Edit Data
      </a>
    </div>
  </div>

  {{-- Statistics Cards --}}
  <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 14px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
      <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; background: linear-gradient(135deg, #ff2d8d, #ff73bc);"></div>
      <div style="display: flex; align-items: center; gap: 15px; position: relative; z-index: 1;">
        <div style="width: 55px; height: 55px; border-radius: 12px; background: linear-gradient(135deg, #ff2d8d, #ff73bc); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; box-shadow: 0 6px 18px rgba(255,45,141,0.3);">
          <i class="fas fa-calendar-check"></i>
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #1f2937; line-height: 1;">{{ $patient->appointments_count ?? 0 }}</div>
          <div style="font-size: 12px; color: #6b7280; font-weight: 500; margin-top: 4px;">Janji Temu</div>
        </div>
      </div>
    </div>

    <div style="background: white; border-radius: 14px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
      <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; background: linear-gradient(135deg, #a855f7, #ff2d8d);"></div>
      <div style="display: flex; align-items: center; gap: 15px; position: relative; z-index: 1;">
        <div style="width: 55px; height: 55px; border-radius: 12px; background: linear-gradient(135deg, #a855f7, #ff2d8d); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; box-shadow: 0 6px 18px rgba(168,85,247,0.3);">
          <i class="fas fa-file-medical"></i>
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #1f2937; line-height: 1;">{{ $patient->medical_records_count ?? 0 }}</div>
          <div style="font-size: 12px; color: #6b7280; font-weight: 500; margin-top: 4px;">Rekam Medis</div>
        </div>
      </div>
    </div>

    <div style="background: white; border-radius: 14px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
      <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; background: linear-gradient(135deg, #3b82f6, #06b6d4);"></div>
      <div style="display: flex; align-items: center; gap: 15px; position: relative; z-index: 1;">
        <div style="width: 55px; height: 55px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; box-shadow: 0 6px 18px rgba(59,130,246,0.3);">
          <i class="fas fa-heartbeat"></i>
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #1f2937; line-height: 1;">{{ $patient->treatment_plans_count ?? 0 }}</div>
          <div style="font-size: 12px; color: #6b7280; font-weight: 500; margin-top: 4px;">Rencana Perawatan</div>
        </div>
      </div>
    </div>

    <div style="background: white; border-radius: 14px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
      <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; background: linear-gradient(135deg, #10b981, #14b8a6);"></div>
      <div style="display: flex; align-items: center; gap: 15px; position: relative; z-index: 1;">
        <div style="width: 55px; height: 55px; border-radius: 12px; background: linear-gradient(135deg, #10b981, #14b8a6); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; box-shadow: 0 6px 18px rgba(16,185,129,0.3);">
          <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #1f2937; line-height: 1;">{{ $controlsCount ?? 0 }}</div>
          <div style="font-size: 12px; color: #6b7280; font-weight: 500; margin-top: 4px;">Jadwal Kontrol</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Janji Temu Section --}}
  @if($latestAppointments->count() > 0)
  <div style="background: white; border-radius: 18px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div style="background: linear-gradient(135deg, #ff2d8d, #ff73bc); padding: 20px; color: white; display: flex; align-items: center; gap: 12px;">
      <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 2px solid rgba(255, 255, 255, 0.3);">
        <i class="fas fa-calendar-check"></i>
      </div>
      <h3 style="margin: 0; font-size: 17px; font-weight: 700;">Janji Temu Terbaru</h3>
    </div>
    <div style="overflow-x: auto;">
      <table class="table">
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
          @foreach($latestAppointments as $appointment)
          <tr>
            <td>{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->format('d M Y') }}</td>
            <td>{{ $appointment->jam_janji ?? '-' }}</td>
            <td>{{ $appointment->dokter->name ?? '-' }}</td>
            <td>{{ Str::limit($appointment->keluhan, 50) }}</td>
            <td>
              <span class="badge {{ $appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'pending' ? 'warning' : 'danger') }}">
                {{ ucfirst($appointment->status) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- Rekam Medis Section --}}
  @if($latestMedicalRecords->count() > 0)
  <div style="background: white; border-radius: 18px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div style="background: linear-gradient(135deg, #a855f7, #ff2d8d); padding: 20px; color: white; display: flex; align-items: center; gap: 12px;">
      <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 2px solid rgba(255, 255, 255, 0.3);">
        <i class="fas fa-file-medical"></i>
      </div>
      <h3 style="margin: 0; font-size: 17px; font-weight: 700;">Rekam Medis Terbaru</h3>
    </div>
    <div style="overflow-x: auto;">
      <table class="table">
        <thead>
          <tr>
            <th>No. RM</th>
            <th>Tanggal</th>
            <th>Dokter</th>
            <th>Diagnosis</th>
            <th>Tindakan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($latestMedicalRecords as $record)
          <tr>
            <td><strong style="color: #ff2d8d;">{{ $record->no_rm }}</strong></td>
            <td>{{ \Carbon\Carbon::parse($record->tanggal_periksa)->format('d M Y') }}</td>
            <td>{{ $record->dokter->name ?? '-' }}</td>
            <td>{{ Str::limit($record->diagnosis, 40) }}</td>
            <td>{{ Str::limit($record->tindakan, 40) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- Rencana Perawatan Section --}}
  @if($latestTreatmentPlans->count() > 0)
  <div style="background: white; border-radius: 18px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div style="background: linear-gradient(135deg, #3b82f6, #06b6d4); padding: 20px; color: white; display: flex; align-items: center; gap: 12px;">
      <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 2px solid rgba(255, 255, 255, 0.3);">
        <i class="fas fa-heartbeat"></i>
      </div>
      <h3 style="margin: 0; font-size: 17px; font-weight: 700;">Rencana Perawatan Terbaru</h3>
    </div>
    <div style="overflow-x: auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Dokter</th>
            <th>Judul</th>
            <th>Detail</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($latestTreatmentPlans as $plan)
          <tr>
            <td>{{ \Carbon\Carbon::parse($plan->tanggal_rencana)->format('d M Y') }}</td>
            <td>{{ $plan->dokter->name ?? '-' }}</td>
            <td><strong>{{ $plan->judul ?? '-' }}</strong></td>
            <td>{{ Str::limit($plan->detail_rencana, 50) }}</td>
            <td>
              <span class="badge {{ $plan->status == 'completed' ? 'success' : ($plan->status == 'draft' ? 'warning' : 'danger') }}">
                {{ ucfirst($plan->status) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  {{-- Jadwal Kontrol Section --}}
  @if($latestControls->count() > 0)
  <div style="background: white; border-radius: 18px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div style="background: linear-gradient(135deg, #10b981, #14b8a6); padding: 20px; color: white; display: flex; align-items: center; gap: 12px;">
      <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 2px solid rgba(255, 255, 255, 0.3);">
        <i class="fas fa-calendar-alt"></i>
      </div>
      <h3 style="margin: 0; font-size: 17px; font-weight: 700;">Jadwal Kontrol Terbaru</h3>
    </div>
    <div style="overflow-x: auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Dokter</th>
            <th>Catatan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($latestControls as $control)
          <tr>
            <td>{{ \Carbon\Carbon::parse($control->tanggal_kontrol)->format('d M Y') }}</td>
            <td>{{ $control->jam_kontrol ?? '-' }}</td>
            <td>{{ $control->dokter->name ?? '-' }}</td>
            <td>{{ Str::limit($control->catatan, 50) ?? '-' }}</td>
            <td>
              <span class="badge {{ $control->status == 'completed' ? 'success' : ($control->status == 'scheduled' ? 'warning' : 'danger') }}">
                {{ ucfirst($control->status) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

@endsection

@push('styles')
<style>
  /* Responsive for statistics cards */
  @media (max-width: 1200px) {
    .form-card > div:nth-child(3) {
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }
  
  @media (max-width: 768px) {
    .form-card > div:nth-child(2) {
      grid-template-columns: 1fr !important;
    }
    .form-card > div:nth-child(3) {
      grid-template-columns: 1fr !important;
    }
  }
</style>
@endpush
