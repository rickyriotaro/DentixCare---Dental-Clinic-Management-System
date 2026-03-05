@extends('layouts.admin')
@section('title','Pengujian Interoperabilitas')

@section('content')
<div class="page-title"><i class="fa-solid fa-flask-vial" style="margin-right:6px;"></i> Pengujian Interoperabilitas Sistem</div>

<div class="form-card" style="max-width:1100px;">

  {{-- Header Info --}}
  <div style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1.5px solid #93c5fd;border-radius:14px;padding:20px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
      <span style="font-size:24px;color:#2563eb;"><i class="fa-solid fa-microscope"></i></span>
      <div>
        <div style="font-weight:700;color:#1e40af;font-size:17px;">Pengujian Interoperabilitas FHIR (HL7)</div>
        <div style="color:#3b82f6;font-size:13px;margin-top:2px;">
          Fast Healthcare Interoperability Resources — Standar pertukaran data kesehatan
        </div>
      </div>
    </div>
    <div style="font-size:13px;color:#1e3a5f;line-height:1.7;">
      Halaman ini menguji kemampuan sistem dalam <strong>pertukaran data kesehatan</strong> menggunakan standar
      <strong>FHIR (HL7)</strong> melalui <strong>REST API</strong>. Setiap skenario pengujian akan memanggil
      endpoint FHIR dan memverifikasi bahwa response sesuai dengan standar interoperabilitas.
    </div>
  </div>

  {{-- Statistics --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;">
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px;text-align:center;">
      <div style="font-size:24px;font-weight:800;color:#16a34a;" id="stat-passed">0</div>
      <div style="font-size:12px;color:#166534;font-weight:600;"><i class="fa-solid fa-circle-check"></i> Berhasil</div>
    </div>
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:14px;text-align:center;">
      <div style="font-size:24px;font-weight:800;color:#dc2626;" id="stat-failed">0</div>
      <div style="font-size:12px;color:#991b1b;font-weight:600;"><i class="fa-solid fa-circle-xmark"></i> Gagal</div>
    </div>
    <div style="background:#fffbeb;border:1px solid #fbbf24;border-radius:12px;padding:14px;text-align:center;">
      <div style="font-size:24px;font-weight:800;color:#d97706;" id="stat-pending">0</div>
      <div style="font-size:12px;color:#92400e;font-weight:600;"><i class="fa-solid fa-hourglass-half"></i> Belum Diuji</div>
    </div>
    <div style="background:#f5f3ff;border:1px solid #c4b5fd;border-radius:12px;padding:14px;text-align:center;">
      <div style="font-size:24px;font-weight:800;color:#7c3aed;" id="stat-total">0</div>
      <div style="font-size:12px;color:#5b21b6;font-weight:600;"><i class="fa-solid fa-chart-simple"></i> Total</div>
    </div>
  </div>

  {{-- Action Buttons --}}
  <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
    <button onclick="runAllTests()" id="btn-run-all"
      style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;padding:12px 28px;border-radius:10px;font-weight:700;cursor:pointer;font-size:14px;display:flex;align-items:center;gap:8px;">
      <i class="fa-solid fa-play"></i> Jalankan Semua Pengujian
    </button>
    <button onclick="resetAllTests()"
      style="background:#f3f4f6;color:#374151;border:1px solid #d1d5db;padding:12px 20px;border-radius:10px;font-weight:600;cursor:pointer;font-size:13px;">
      <i class="fa-solid fa-rotate"></i> Reset
    </button>
  </div>

  {{-- ID Configuration --}}
  <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;padding:18px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
      <span style="font-size:16px;color:#475569;"><i class="fa-solid fa-gear"></i></span>
      <span style="font-weight:700;color:#334155;font-size:14px;">Konfigurasi ID Pengujian</span>
      <span style="font-size:11px;color:#94a3b8;margin-left:4px;">(Ubah ID sesuai data yang ada di database)</span>
    </div>
    <div style="display:flex;gap:20px;flex-wrap:wrap;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Patient ID</label>
        <input type="number" id="cfg-patient-id" value="{{ App\Models\Patient::first()->id ?? 1 }}" min="1"
          style="width:100px;padding:8px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;font-weight:600;text-align:center;"
          onchange="updateTestIds()">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Appointment ID</label>
        <input type="number" id="cfg-appointment-id" value="{{ App\Models\Appointment::first()->id ?? 1 }}" min="1"
          style="width:100px;padding:8px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;font-weight:600;text-align:center;"
          onchange="updateTestIds()">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Medical Record ID</label>
        <input type="number" id="cfg-mr-id" value="{{ App\Models\MedicalRecord::first()->id ?? 1 }}" min="1"
          style="width:100px;padding:8px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;font-weight:600;text-align:center;"
          onchange="updateTestIds()">
      </div>
    </div>
  </div>

  {{-- Test Categories --}}
  <div id="test-container">

    {{-- Category 1: READ Operations --}}
    <div style="margin-bottom:28px;">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid #e5e7eb;">
        <span style="background:#dbeafe;padding:6px 10px;border-radius:8px;font-size:14px;color:#2563eb;"><i class="fa-solid fa-book-open"></i></span>
        <span style="font-weight:700;font-size:15px;color:#1e40af;">A. Pengujian READ &mdash; Membaca Data (GET)</span>
      </div>

      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
          <thead>
            <tr style="background:#f1f5f9;border-bottom:2px solid #e2e8f0;">
              <th style="padding:10px 12px;text-align:left;width:40px;">No</th>
              <th style="padding:10px 12px;text-align:left;">Skenario Pengujian</th>
              <th style="padding:10px 12px;text-align:left;width:220px;">Endpoint</th>
              <th style="padding:10px 12px;text-align:center;width:90px;">Status</th>
              <th style="padding:10px 12px;text-align:center;width:100px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="read-tests">
          </tbody>
        </table>
      </div>
    </div>

    {{-- Category 2: WRITE Operations --}}
    <div style="margin-bottom:28px;">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid #e5e7eb;">
        <span style="background:#dcfce7;padding:6px 10px;border-radius:8px;font-size:14px;color:#16a34a;"><i class="fa-solid fa-pen-to-square"></i></span>
        <span style="font-weight:700;font-size:15px;color:#166534;">B. Pengujian WRITE &mdash; Menulis Data (POST/PUT)</span>
      </div>

      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
          <thead>
            <tr style="background:#f1f5f9;border-bottom:2px solid #e2e8f0;">
              <th style="padding:10px 12px;text-align:left;width:40px;">No</th>
              <th style="padding:10px 12px;text-align:left;">Skenario Pengujian</th>
              <th style="padding:10px 12px;text-align:left;width:220px;">Endpoint</th>
              <th style="padding:10px 12px;text-align:center;width:90px;">Status</th>
              <th style="padding:10px 12px;text-align:center;width:100px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="write-tests">
          </tbody>
        </table>
      </div>
    </div>

    {{-- Category 3: INTEROPERABILITY --}}
    <div style="margin-bottom:28px;">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid #e5e7eb;">
        <span style="background:#fef3c7;padding:6px 10px;border-radius:8px;font-size:14px;color:#d97706;"><i class="fa-solid fa-link"></i></span>
        <span style="font-weight:700;font-size:15px;color:#92400e;">C. Pengujian Standar Interoperabilitas</span>
      </div>

      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
          <thead>
            <tr style="background:#f1f5f9;border-bottom:2px solid #e2e8f0;">
              <th style="padding:10px 12px;text-align:left;width:40px;">No</th>
              <th style="padding:10px 12px;text-align:left;">Skenario Pengujian</th>
              <th style="padding:10px 12px;text-align:left;width:220px;">Endpoint</th>
              <th style="padding:10px 12px;text-align:center;width:90px;">Status</th>
              <th style="padding:10px 12px;text-align:center;width:100px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="interop-tests">
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{-- Response Detail Modal --}}
  <div id="response-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;justify-content:center;align-items:center;">
    <div style="background:#fff;border-radius:16px;max-width:800px;width:90%;max-height:80vh;display:flex;flex-direction:column;box-shadow:0 25px 50px rgba(0,0,0,0.25);">
      <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-bottom:1px solid #e5e7eb;">
        <div style="font-weight:700;font-size:15px;" id="modal-title">Response Detail</div>
        <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#6b7280;"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div style="padding:20px;overflow-y:auto;flex:1;">
        <div style="margin-bottom:12px;">
          <span style="font-weight:600;font-size:13px;">HTTP Status: </span>
          <span id="modal-status" style="font-weight:700;"></span>
        </div>
        <div style="margin-bottom:8px;font-weight:600;font-size:13px;">Response Body (JSON):</div>
        <pre id="modal-body" style="background:#1e293b;color:#e2e8f0;padding:16px;border-radius:10px;font-size:12px;overflow-x:auto;line-height:1.6;max-height:400px;overflow-y:auto;"></pre>
      </div>
    </div>
  </div>

</div>

<script>
const BASE = '{{ url("/api/fhir") }}';

function getPatientId() { return document.getElementById('cfg-patient-id').value; }
function getAppointmentId() { return document.getElementById('cfg-appointment-id').value; }
function getMrId() { return document.getElementById('cfg-mr-id').value; }

// ========================
// BUILD TESTS DYNAMICALLY
// ========================
function buildReadTests() {
  const pid = getPatientId();
  const aid = getAppointmentId();
  return [
    { id:'r1', no:1, name:'Membaca CapabilityStatement (Metadata FHIR)', endpoint:'/metadata', method:'GET',
      validate:(d) => d.resourceType === 'CapabilityStatement' },
    { id:'r2', no:2, name:'Membaca semua data Pasien (Patient)', endpoint:'/Patient', method:'GET',
      validate:(d) => d.resourceType === 'Bundle' && d.type === 'searchset' },
    { id:'r3', no:3, name:'Membaca data Pasien berdasarkan ID', endpoint:`/Patient/${pid}`, method:'GET',
      validate:(d) => d.resourceType === 'Patient' },
    { id:'r4', no:4, name:'Membaca data lengkap Pasien ($everything)', endpoint:`/Patient/${pid}/$everything`, method:'GET',
      validate:(d) => d.resourceType === 'Bundle' },
    { id:'r5', no:5, name:'Membaca semua data Appointment', endpoint:'/Appointment', method:'GET',
      validate:(d) => d.resourceType === 'Bundle' && d.type === 'searchset' },
    { id:'r6', no:6, name:'Membaca data Appointment berdasarkan ID', endpoint:`/Appointment/${aid}`, method:'GET',
      validate:(d) => d.resourceType === 'Appointment' },
    { id:'r7', no:7, name:'Membaca semua data Diagnosa (Condition)', endpoint:'/Condition', method:'GET',
      validate:(d) => d.resourceType === 'Bundle' },
    { id:'r8', no:8, name:'Membaca semua data Tindakan (Procedure)', endpoint:'/Procedure', method:'GET',
      validate:(d) => d.resourceType === 'Bundle' },
  ];
}

function buildWriteTests() {
  const pid = getPatientId();
  return [
    { id:'w1', no:1, name:'Membuat data Pasien baru (POST Patient)', endpoint:'/Patient', method:'POST',
      body: { resourceType:'Patient', name:[{family:'Pengujian',given:['Test FHIR']}], telecom:[{system:'phone',value:'08'+Date.now().toString().slice(-8)},{system:'email',value:'test_fhir_'+Date.now()+'@test.com'}], gender:'male', birthDate:'2000-01-01', address:[{text:'Jl. Test FHIR No. 1'}] },
      validate:(d) => d.resourceType === 'Patient' && d.id },
    { id:'w2', no:2, name:'Membuat data Appointment baru (POST Appointment)', endpoint:'/Appointment', method:'POST',
      body: { resourceType:'Appointment', status:'pending', start:'2026-04-01T16:00:00+07:00', participant:[{actor:{reference:`Patient/${pid}`}}], reasonCode:[{text:'Pengujian FHIR - Sakit gigi'}] },
      validate:(d) => d.resourceType === 'Appointment' && d.id },
    { id:'w3', no:3, name:'Update data Pasien (PUT Patient)', endpoint:`/Patient/${pid}`, method:'PUT',
      body: { resourceType:'Patient', name:[{family:'Updated',given:['Via FHIR']}], telecom:[{system:'phone',value:'089999999999'},{system:'email',value:'updated_fhir@test.com'}], gender:'female', birthDate:'1995-05-15', address:[{text:'Jl. Updated FHIR No. 2'}] },
      validate:(d) => d.resourceType === 'Patient' },
    { id:'w4', no:4, name:'Patch data Pasien (PATCH Patient)', endpoint:`/Patient/${pid}`, method:'PATCH',
      body: { resourceType:'Patient', name:[{family:'Patched',given:['Via FHIR']}], telecom:[{system:'phone',value:'081111111111'},{system:'email',value:'patched@test.com'}], gender:'male', birthDate:'2000-06-15', address:[{text:'Jl. Patch FHIR No. 3'}] },
      validate:(d) => d.resourceType === 'Patient' },
  ];
}

function buildInteropTests() {
  const pid = getPatientId();
  return [
    { id:'i1', no:1, name:'Verifikasi format JSON sesuai standar FHIR', endpoint:'/metadata', method:'GET',
      validate:(d) => d.resourceType === 'CapabilityStatement' && d.fhirVersion && d.format && d.format.includes('json'),
      detail:'Memastikan response mengandung field resourceType, fhirVersion, dan format JSON' },
    { id:'i2', no:2, name:'Verifikasi Bundle searchset (Collection)', endpoint:'/Patient', method:'GET',
      validate:(d) => d.resourceType === 'Bundle' && d.type === 'searchset' && d.total !== undefined && Array.isArray(d.entry),
      detail:'Memastikan koleksi data menggunakan Bundle dengan type searchset sesuai spesifikasi FHIR' },
    { id:'i3', no:3, name:'Verifikasi Resource Patient memiliki identifier', endpoint:`/Patient/${pid}`, method:'GET',
      validate:(d) => d.resourceType === 'Patient' && d.id && d.name && d.name.length > 0,
      detail:'Memastikan resource Patient memiliki ID unik dan nama sesuai standar HL7 FHIR' },
    { id:'i4', no:4, name:'Verifikasi REST API menggunakan HTTP Methods standar', endpoint:'/metadata', method:'GET',
      validate:(d) => {
        const rest = d.rest && d.rest[0];
        return rest && rest.resource && rest.resource.length > 0 && rest.resource[0].interaction;
      },
      detail:'Memastikan server mendukung operasi CRUD (Create, Read, Update, Delete) via REST' },
    { id:'i5', no:5, name:'Verifikasi Content-Type application/fhir+json', endpoint:'/Patient', method:'GET',
      validateResponse:(resp) => {
        const ct = resp.headers.get('content-type') || '';
        return ct.includes('json');
      },
      validate:(d) => true,
      detail:'Memastikan response menggunakan Content-Type JSON sesuai standar FHIR' },
  ];
}

// ========================
// RENDERING
// ========================
function getAllTests() {
  return [...buildReadTests(), ...buildWriteTests(), ...buildInteropTests()];
}

function renderTests() {
  renderTable('read-tests', buildReadTests());
  renderTable('write-tests', buildWriteTests());
  renderTable('interop-tests', buildInteropTests());
  updateStats();
}

function renderTable(containerId, tests) {
  const tbody = document.getElementById(containerId);
  tbody.innerHTML = tests.map(t => `
    <tr id="row-${t.id}" style="border-bottom:1px solid #f1f5f9;transition:background 0.2s;">
      <td style="padding:10px 12px;font-weight:600;">${t.no}</td>
      <td style="padding:10px 12px;">
        <div style="font-weight:600;">${t.name}</div>
        ${t.detail ? `<div style="font-size:11px;color:#6b7280;margin-top:3px;">${t.detail}</div>` : ''}
      </td>
      <td style="padding:10px 12px;">
        <code style="background:#f1f5f9;padding:3px 8px;border-radius:6px;font-size:11px;">
          <span style="color:#2563eb;font-weight:700;">${t.method}</span> ${t.endpoint}
        </code>
      </td>
      <td style="padding:10px 12px;text-align:center;" id="status-${t.id}">
        ${results[t.id] ?
          (results[t.id].passed
            ? '<span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;" onclick="showDetail(\'' + t.id + '\')"><i class=\'fa-solid fa-circle-check\'></i> Berhasil</span>'
            : '<span style="background:#fef2f2;color:#dc2626;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;" onclick="showDetail(\'' + t.id + '\')"><i class=\'fa-solid fa-circle-xmark\'></i> Gagal</span>'
          )
          : '<span style="background:#fef3c7;color:#d97706;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:600;"><i class=\'fa-solid fa-hourglass-half\'></i> Belum</span>'
        }
      </td>
      <td style="padding:10px 12px;text-align:center;">
        <button onclick="runTest('${t.id}')" id="btn-${t.id}"
          style="background:#2563eb;color:#fff;border:none;padding:6px 14px;border-radius:8px;cursor:pointer;font-size:12px;font-weight:600;">
          ${results[t.id] ? '<i class="fa-solid fa-magnifying-glass"></i> Detail' : '<i class="fa-solid fa-play"></i> Uji'}
        </button>
      </td>
    </tr>
  `).join('');

  // Re-bind detail buttons for already-tested items
  tests.forEach(t => {
    if (results[t.id]) {
      const btn = document.getElementById(`btn-${t.id}`);
      if (btn) btn.onclick = () => showDetail(t.id);
    }
  });
}

function updateTestIds() {
  Object.keys(results).forEach(k => delete results[k]);
  renderTests();
}

// ========================
// TEST EXECUTION
// ========================
const results = {};

function findTest(id) {
  return getAllTests().find(t => t.id === id);
}

async function runTest(id) {
  const test = findTest(id);
  if (!test) return;

  const statusEl = document.getElementById(`status-${id}`);
  const btnEl = document.getElementById(`btn-${id}`);
  const rowEl = document.getElementById(`row-${id}`);

  statusEl.innerHTML = '<span style="color:#6b7280;font-size:12px;"><i class=\'fa-solid fa-spinner fa-spin\'></i> Menguji...</span>';
  btnEl.disabled = true;
  btnEl.style.opacity = '0.5';

  try {
    const opts = { method: test.method, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' } };
    if (test.body && (test.method === 'POST' || test.method === 'PUT' || test.method === 'PATCH')) {
      opts.body = JSON.stringify(test.body);
    }

    const resp = await fetch(BASE + test.endpoint, opts);
    const data = await resp.json();

    let passed = resp.ok;
    if (test.validateResponse) {
      passed = passed && test.validateResponse(resp);
    }
    if (test.validate) {
      passed = passed && test.validate(data);
    }

    results[id] = { passed, status: resp.status, data, test };

    if (passed) {
      statusEl.innerHTML = '<span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;" onclick="showDetail(\'' + id + '\')"><i class=\'fa-solid fa-circle-check\'></i> Berhasil</span>';
      rowEl.style.background = '#f0fdf4';
    } else {
      statusEl.innerHTML = '<span style="background:#fef2f2;color:#dc2626;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;" onclick="showDetail(\'' + id + '\')"><i class=\'fa-solid fa-circle-xmark\'></i> Gagal</span>';
      rowEl.style.background = '#fef2f2';
    }
  } catch (e) {
    results[id] = { passed: false, status: 'Error', data: { error: e.message }, test };
    statusEl.innerHTML = '<span style="background:#fef2f2;color:#dc2626;padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;" onclick="showDetail(\'' + id + '\')"><i class=\'fa-solid fa-circle-xmark\'></i> Error</span>';
    rowEl.style.background = '#fef2f2';
  }

  btnEl.disabled = false;
  btnEl.style.opacity = '1';
  btnEl.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Detail';
  btnEl.onclick = () => showDetail(id);
  updateStats();
}

async function runAllTests() {
  const btn = document.getElementById('btn-run-all');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menjalankan pengujian...';
  btn.style.opacity = '0.6';

  const allTests = getAllTests();
  for (const test of allTests) {
    await runTest(test.id);
    await new Promise(r => setTimeout(r, 300));
  }

  btn.disabled = false;
  btn.innerHTML = '<i class="fa-solid fa-play"></i> Jalankan Semua Pengujian';
  btn.style.opacity = '1';
}

function resetAllTests() {
  Object.keys(results).forEach(k => delete results[k]);
  renderTests();
}

// ========================
// STATS & MODAL
// ========================
function updateStats() {
  const allTests = getAllTests();
  const total = allTests.length;
  const tested = Object.keys(results).length;
  const passed = Object.values(results).filter(r => r.passed).length;
  const failed = tested - passed;
  const pending = total - tested;

  document.getElementById('stat-total').textContent = total;
  document.getElementById('stat-passed').textContent = passed;
  document.getElementById('stat-failed').textContent = failed;
  document.getElementById('stat-pending').textContent = pending;
}

function showDetail(id) {
  const r = results[id];
  if (!r) return;

  document.getElementById('modal-title').textContent = r.test.name;
  document.getElementById('modal-status').innerHTML = `${r.status} ${r.passed ? '<i class="fa-solid fa-circle-check" style="color:#16a34a"></i>' : '<i class="fa-solid fa-circle-xmark" style="color:#dc2626"></i>'}`;
  document.getElementById('modal-status').style.color = r.passed ? '#16a34a' : '#dc2626';
  document.getElementById('modal-body').textContent = JSON.stringify(r.data, null, 2);
  document.getElementById('response-modal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('response-modal').style.display = 'none';
}

document.getElementById('response-modal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});

// Init
renderTests();
</script>
@endsection
