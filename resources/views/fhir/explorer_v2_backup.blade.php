@extends('layouts.admin')

@section('title', 'FHIR Explorer')

@section('content')
<style>
/* Tab System */
.tab-nav {
    display: flex;
    gap: 0;
    margin-bottom: 2rem;
    border-bottom: 2px solid #fce7f3;
    background: white;
    border-radius: 15px 15px 0 0;
    overflow: hidden;
}

.tab-btn {
    flex: 1;
    padding: 1.25rem 2rem;
    background: #f9fafb;
    border: none;
    border-bottom: 3px solid transparent;
    color: #6b7280;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.05rem;
}

.tab-btn:hover {
    color: #ec4899;
    background: #fce7f3;
}

.tab-btn.active {
    color: #ec4899;
    background: white;
    border-bottom-color: #ec4899;
}

.tab-btn i {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

.tab-content {
    display: none;
    animation: fadeIn 0.4s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Parameter Builder Styles */
.resource-type-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.resource-card {
    padding: 1.5rem;
    background: white;
    border: 3px solid #fce7f3;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.resource-card:hover {
    border-color: #f9a8d4;
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(236, 72, 153, 0.15);
}

.resource-card.active {
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border-color: #ec4899;
    box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);
}

.resource-card i {
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
    display: block;
}

.resource-card .resource-name {
    font-weight: 700;
    font-size: 1rem;
    display: block;
}

.param-form {
    background: white;
    border-radius: 15px;
    padding: 2.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 2px solid #fce7f3;
}

.param-section-title {
    color: #ec4899;
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #fce7f3;
}

.param-group {
    margin-bottom: 1.75rem;
}

.param-label {
    display: block;
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.param-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.param-hint {
    color: #6b7280;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    font-style: italic;
}

.param-input, .param-select {
    width: 100%;
    padding: 0.875rem 1.25rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.param-input:focus, .param-select:focus {
    outline: none;
    border-color: #ec4899;
    background: white;
    box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
}

.param-checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.param-checkbox {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    background: #fce7f3;
    border: 2px solid #fbcfe8;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.param-checkbox:hover {
    background: #fbcfe8;
    border-color: #f9a8d4;
}

.param-checkbox.checked {
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border-color: #ec4899;
}

.param-checkbox input[type="checkbox"] {
    margin-right: 0.75rem;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.url-preview-box {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.75rem;
    border-radius: 12px;
    font-family: 'Courier New', monospace;
    font-size: 0.95rem;
    overflow-x: auto;
    margin: 2rem 0;
    border: 3px solid #ec4899;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.url-preview-box .method {
    color: #10b981;
    font-weight: bold;
    margin-right: 1rem;
    font-size: 1.1rem;
}

.url-preview-box   .url {
    color: #60a5fa;
    word-break: break-all;
}

.execute-btn {
    width: 100%;
    padding: 1.25rem;
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
}

.execute-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(236, 72, 153, 0.4);
}

.execute-btn:active {
    transform: translateY(-1px);
}

.execute-btn i {
    margin-right: 0.75rem;
    font-size: 1.3rem;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header" style="background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); padding: 2.5rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);">
                <h1 style="color: white; margin: 0; font-size: 2.25rem; font-weight: 700;">
                    <i class="fas fa-server"></i> FHIR API Explorer
                </h1>
                <p style="color: rgba(255,255,255,0.95); margin: 0.75rem 0 0 0; font-size: 1.05rem;">
                    🚀 Test & explore FHIR endpoints with advanced parameter builder
                </p>
            </div>

            <!-- Tab Navigation -->
            <div class="tab-nav">
                <button class="tab-btn active" onclick="switchTab('quickTest')">
                    <i class="fas fa-bolt"></i> Quick Test
                </button>
                <button class="tab-btn" onclick="switchTab('paramBuilder')">
                    <i class="fas fa-sliders-h"></i> Parameter Builder
                </button>
            </div>

            <!-- TAB 1: Quick Test -->
            <div id="quickTest" class="tab-content active">
                <!-- Quick Access Buttons -->
                <div class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                    <div class="card-body" style="padding: 2rem;">
                        <h5 style="color: #ec4899; margin-bottom: 1.5rem; font-weight: 600;">
                            <i class="fas fa-rocket"></i> Quick Endpoints
                        </h5>
                        
                        <div class="row g-3">
                            <!-- Quick buttons tetap sama seperti sebelumnya -->
                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('metadata')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-info-circle"></i> Server Capabilities
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/metadata</div>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('Patient?_count=10')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-users"></i> All Patients (10)
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient?_count=10</div>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('Patient/1/$everything')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-database"></i> Patient Everything
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient/1/$everything</div>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('Patient/1')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-user"></i> Single Patient
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient/1</div>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('Appointment?patient=1')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-calendar"></i> Appointments
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Appointment?patient=1</div>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <button class="endpoint-btn" onclick="loadEndpoint('Condition?patient=1')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                    <i class="fas fa-notes-medical"></i> Conditions
                                    <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Condition?patient=1</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Endpoint -->
                <div class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                    <div class="card-body" style="padding: 2rem;">
                        <h5 style="color: #ec4899; margin-bottom: 1.5rem; font-weight: 600;">
                            <i class="fas fa-terminal"></i> Custom Endpoint
                        </h5>
                        
                        <div class="input-group" style="margin-bottom: 1rem;">
                            <span class="input-group-text" style="background: #ec4899; color: white; border: none; font-weight: 500;">
                                {{ url('/api/fhir') }}/
                            </span>
                            <input type="text" id="customEndpoint" class="form-control" placeholder="e.g. Patient/2 or Patient?_count=20" style="border: 2px solid #fce7f3; padding: 0.75rem;">
                            <button class="btn" onclick="loadCustomEndpoint()" style="background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); color: white; border: none; padding: 0.75rem 2rem; font-weight: 500;">
                                <i class="fas fa-play"></i> Execute
                            </button>
                        </div>
                        
                        <small style="color: #666;">
                            <i class="fas fa-info-circle"></i> Enter endpoint path (e.g., "Patient/5" or "Procedure?patient=2&_count=5")
                        </small>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Parameter Builder (NEW!) -->
            <div id="paramBuilder" class="tab-content">
                <div class="param-form">
                    <h4 class="param-section-title">
                        <i class="fas fa-layer-group"></i> 1. Select Resource Type
                    </h4>
                    
                    <div class="resource-type-grid">
                        <div class="resource-card active" onclick="selectResource('Patient')">
                            <i class="fas fa-user-injured"></i>
                            <span class="resource-name">Patient</span>
                        </div>
                        <div class="resource-card" onclick="selectResource('Appointment')">
                            <i class="fas fa-calendar-check"></i>
                            <span class="resource-name">Appointment</span>
                        </div>
                        <div class="resource-card" onclick="selectResource('Condition')">
                            <i class="fas fa-notes-medical"></i>
                            <span class="resource-name">Condition</span>
                        </div>
                        <div class="resource-card" onclick="selectResource('Procedure')">
                            <i class="fas fa-procedures"></i>
                            <span class="resource-name">Procedure</span>
                        </div>
                    </div>

                    <h4 class="param-section-title" style="margin-top: 2.5rem;">
                        <i class="fas fa-cog"></i> 2. Set Parameters
                    </h4>

                    <!-- Common Parameters -->
                    <div id="commonParams">
                        <div class="param-group">
                            <label class="param-label">
                                <i class="fas fa-hashtag"></i> Count (_count)
                            </label>
                            <input type="number" id="param_count" class="param-input" placeholder="10" value="10" min="1" max="100">
                            <div class="param-hint">Number of results to return (1-100)</div>
                        </div>
                    </div>

                    <!-- Resource-specific Parameters -->
                    <div id="resourceParams">
                        <!-- Will be populated dynamically -->
                    </div>

                    <h4 class="param-section-title" style="margin-top: 2.5rem;">
                        <i class="fas fa-eye"></i> 3. Preview & Execute
                    </h4>

                    <div class="url-preview-box">
                        <span class="method">GET</span>
                        <span class="url" id="urlPreview">{{ url('/api/fhir') }}/Patient?_count=10</span>
                    </div>

                    <button class="execute-btn" onclick="executeBuiltEndpoint()">
                        <i class="fas fa-rocket"></i> Execute Request
                    </button>
                </div>
            </div>

            <!-- Response Section (Shared) -->
            <div id="responseCard" class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: none; margin-top: 2rem;">
                <div class="card-body" style="padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h5 style="color: #ec4899; margin: 0; font-weight: 600;">
                            <i class="fas fa-code"></i> Response
                        </h5>
                        <div>
                            <span id="statusBadge" class="badge" style="padding: 0.5rem 1rem; font-size: 0.9rem;">200 OK</span>
                            <button onclick="copyResponse()" class="btn btn-sm" style="background: #ec4899; color: white; margin-left: 0.5rem;">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    
                    <!-- Loading -->
                    <div id="loading" style="text-align: center; padding: 3rem; display: none;">
                        <div class="spinner-border" style="color: #ec4899; width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p style="margin-top: 1rem; color: #666;">Fetching FHIR data...</p>
                    </div>
                    
                    <!-- Response Content -->
                    <pre id="responseContent" style="background: #1e1e1e; color: #d4d4d4; padding: 1.5rem; border-radius: 10px; max-height: 600px; overflow: auto; font-family: 'Courier New', monospace; font-size: 0.9rem;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.endpoint-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.endpoint-btn:active {
    transform: translateY(0);
}

/* JSON Syntax Highlighting */
.json-key { color: #9cdcfe; }
.json-value { color: #ce9178; }
.json-string { color: #ce9178; }
.json-number { color: #b5cea8; }
.json-boolean { color: #569cd6; }
.json-null { color: #569cd6; }
</style>

<script>
let currentResponse = null;
let selectedResource = 'Patient';
let builtParams = { _count: 10 };

// Tab switching
function switchTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.tab-btn').classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabName).classList.add('active');
}

// Resource selection
function selectResource(resource) {
    selectedResource = resource;
    
    // Update visual selection
    document.querySelectorAll('.resource-card').forEach(card => card.classList.remove('active'));
    event.target.closest('.resource-card').classList.add('active');
    
    // Update parameters based on resource
    updateResourceParams(resource);
    updateUrlPreview();
}

// Update resource-specific parameters
function updateResourceParams(resource) {
    const container = document.getElementById('resourceParams');
    
    let html = '';
    
    if (resource === 'Patient') {
        html = `
            <div class="param-group">
                <label class="param-label">
                    <i class="fas fa-user"></i> Patient ID (optional)
                </label>
                <input type="number" id="param_patient_id" class="param-input" placeholder="Leave empty for all patients" onchange="updateUrlPreview()">
                <div class="param-hint">Enter specific patient ID or leave empty for search</div>
            </div>
        `;
    } else if (resource === 'Appointment') {
        html = `
            <div class="param-group">
                <label class="param-label">
                    <i class="fas fa-user"></i> Patient ID
                </label>
                <input type="number" id="param_patient" class="param-input" placeholder="e.g., 1" onchange="updateUrlPreview()">
                <div class="param-hint">Filter appointments by patient ID</div>
            </div>
        `;
    } else if (resource === 'Condition') {
        html = `
            <div class="param-group">
                <label class="param-label">
                    <i class="fas fa-user"></i> Patient ID
                </label>
                <input type="number" id="param_patient" class="param-input" placeholder="e.g., 1" onchange="updateUrlPreview()">
                <div class="param-hint">Filter conditions by patient ID</div>
            </div>
        `;
    } else if (resource === 'Procedure') {
        html = `
            <div class="param-group">
                <label class="param-label">
                    <i class="fas fa-user"></i> Patient ID
                </label>
                <input type="number" id="param_patient" class="param-input" placeholder="e.g., 1" onchange="updateUrlPreview()">
                <div class="param-hint">Filter procedures by patient ID</div>
            </div>
        `;
    }
    
    container.innerHTML = html;
}

// Update URL preview
function updateUrlPreview() {
    let url = '{{ url("/api/fhir") }}/' + selectedResource;
    let params = [];
    
    // Get patient ID for specific resource request
    const patientIdInput = document.getElementById('param_patient_id');
    if (patientIdInput && patientIdInput.value) {
        url += '/' + patientIdInput.value;
    } else {
        // Add query parameters
        const patientInput = document.getElementById('param_patient');
        if (patientInput && patientInput.value) {
            params.push('patient=' + patientInput.value);
        }
        
        const countInput = document.getElementById('param_count');
        if (countInput && countInput.value) {
            params.push('_count=' + countInput.value);
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
    }
    
    document.getElementById('urlPreview').textContent = url;
}

// Execute built endpoint
function executeBuiltEndpoint() {
    const url = document.getElementById('urlPreview').textContent;
    const endpoint = url.replace('{{ url("/api/fhir") }}/', '');
    loadEndpoint(endpoint);
}

// Load endpoint (existing function)
function loadEndpoint(endpoint) {
    const responseCard = document.getElementById('responseCard');
    const loading = document.getElementById('loading');
    const responseContent = document.getElementById('responseContent');
    const statusBadge = document.getElementById('statusBadge');
    
    // Show loading
    responseCard.style.display = 'block';
    loading.style.display = 'block';
    responseContent.style.display = 'none';
    
    // Smooth scroll to response
    responseCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Fetch data
    fetch('{{ url("/api/fhir") }}/' + endpoint)
        .then(response => {
            const status = response.status;
            statusBadge.textContent = status + ' ' + (status === 200 ? 'OK' : 'Error');
            statusBadge.className = 'badge ' + (status === 200 ? 'bg-success' : 'bg-danger');
            return response.json();
        })
        .then(data => {
            currentResponse = data;
            loading.style.display = 'none';
            responseContent.style.display = 'block';
            responseContent.textContent = JSON.stringify(data, null, 2);
            syntaxHighlight(responseContent);
        })
        .catch(error => {
            loading.style.display = 'none';
            responseContent.style.display = 'block';
            responseContent.textContent = 'Error: ' + error.message;
            statusBadge.textContent = 'ERROR';
            statusBadge.className = 'badge bg-danger';
        });
}

function loadCustomEndpoint() {
    const endpoint = document.getElementById('customEndpoint').value.trim();
    if (!endpoint) {
        alert('Please enter an endpoint');
        return;
    }
    loadEndpoint(endpoint);
}

function copyResponse() {
    const text = JSON.stringify(currentResponse, null, 2);
    navigator.clipboard.writeText(text).then(() => {
        alert('Response copied to clipboard!');
    });
}

function syntaxHighlight(element) {
    let json = element.textContent;
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    json = json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        let cls = 'json-number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'json-key';
            } else {
                cls = 'json-string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'json-boolean';
        } else if (/null/.test(match)) {
            cls = 'json-null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
    element.innerHTML = json;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Allow Enter key on custom endpoint input
    const customEndpointInput = document.getElementById('customEndpoint');
    if (customEndpointInput) {
        customEndpointInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                loadCustomEndpoint();
            }
        });
    }
    
    // Initialize parameter inputs change listeners
    const paramCount = document.getElementById('param_count');
    if (paramCount) {
        paramCount.addEventListener('input', updateUrlPreview);
    }
    
    // Initialize resource params
    updateResourceParams('Patient');
});
</script>
@endsection
