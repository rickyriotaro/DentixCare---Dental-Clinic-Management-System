@extends('layouts.admin')

@section('title', 'FHIR API Explorer')

@section('content')
<style>
/* Global Container - FULL WIDTH (Override Everything!) */
body {
    overflow-x: hidden !important;
}

.container-fluid {
    max-width: 100% !important;
    width: 100% !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    overflow-x: hidden !important;
    margin: 0 !important;
}

.container-fluid .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
    max-width: 100% !important;
}

.container-fluid .col-12 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    max-width: 100% !important;
    width: 100% !important;
}

/* All cards and panels */
.request-builder,
.quick-templates,
.card {
    max-width: 100% !important;
    box-sizing: border-box !important;
}

/* Request Builder Styles */
.request-builder {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
}

.request-header {
    background: linear-gradient(135deg, #f9fafb 0%, #fff 100%);
    padding: 1.5rem 2rem;
    border-bottom: 2px solid #fce7f3;
}

.request-line {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.method-selector {
    min-width: 140px;
}

.method-select {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.method-select:focus {
    outline: none;
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

.method-GET { color: #10b981; }
.method-POST { color: #3b82f6; }
.method-PUT { color: #f59e0b; }
.method-PATCH { color: #8b5cf6; }
.method-DELETE { color: #ef4444; }

.url-input-group {
    flex: 1;
    display: flex;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.url-input-group:focus-within {
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

.url-prefix {
    padding: 0.875rem 1.25rem;
    background: #ec4899;
    color: white;
    font-weight: 600;
    white-space: nowrap;
}

.url-input {
    flex: 1;
    padding: 0.875rem 1.25rem;
    border: none;
    background: transparent;
    font-size: 1rem;
    font-family: 'Courier New', monospace;
}

.url-input:focus {
    outline: none;
}

.send-btn {
    padding: 0.875rem 2.5rem;
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.05rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
}

.send-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(236, 72, 153, 0.4);
}

.send-btn:active {
    transform: translateY(0);
}

/* Request Tabs */
.request-tabs {
    display: flex;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.request-tab {
    padding: 1rem 2rem;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: #6b7280;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.request-tab:hover {
    color: #ec4899;
    background: rgba(236, 72, 153, 0.05);
}

.request-tab.active {
    color: #ec4899;
    background: white;
    border-bottom-color: #ec4899;
}

.request-tab .badge {
    margin-left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: #e5e7eb;
    color: #6b7280;
    border-radius: 12px;
    font-size: 0.75rem;
}

.request-tab.active .badge {
    background: #fce7f3;
    color: #ec4899;
}

.tab-panel {
    display: none;
    padding: 2rem;
    max-width: 100%;
    box-sizing: border-box;
    overflow-x: hidden;
}

.tab-panel.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

/* Headers & Params Editor */
.kv-editor {
    margin-bottom: 1rem;
}

.kv-row {
    display: grid;
    grid-template-columns: 40px 1fr 1fr 80px;
    gap: 1rem;
    margin-bottom: 0.75rem;
    align-items: center;
}

.kv-checkbox {
    display: flex;
    align-items: center;
    justify-content: center;
}

.kv-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.kv-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.kv-input:focus {
    outline: none;
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

.kv-input:disabled {
    background: #f3f4f6;
    color: #9ca3af;
}

.kv-delete-btn {
    padding: 0.5rem;
    background: #fee2e2;
    color: #ef4444;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.kv-delete-btn:hover {
    background: #fecaca;
}

.add-kv-btn {
    padding: 0.75rem 1.5rem;
    background: #f3f4f6;
    color: #6b7280;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-kv-btn:hover {
    background: #fce7f3;
    border-color: #ec4899;
    color: #ec4899;
}

/* Body Editor */
.body-editor {
    position: relative;
    width: 100%;
    max-width: 100%;
}

.body-type-selector {
    margin-bottom: 1rem;
    display: flex;
    gap: 1rem;
}

.body-type-btn {
    padding: 0.625rem 1.25rem;
    background: #f3f4f6;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    color: #6b7280;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.body-type-btn.active {
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border-color: #ec4899;
}

.json-editor {
    width: 100%;
    min-height: 300px;
    max-width: 100%;
    padding: 1.25rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-family: 'Courier New', monospace;
    font-size: 0.95rem;
    line-height: 1.6;
    background: #1e1e1e;
    color: #d4d4d4;
    resize: vertical;
    box-sizing: border-box;
}

.json-editor:focus {
    outline: none;
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

/* Response Section */
.response-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.response-meta {
    display: flex;
    gap: 1.5rem;
    align-items: center;
}

.status-badge {
    padding: 0.5rem 1.25rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.95rem;
}

.status-200 { background: #d1fae5; color: #065f46; }
.status-201 { background: #dbeafe; color: #1e40af; }
.status-400 { background: #fef3c7; color: #92400e; }
.status-404 { background: #fed7aa; color: #9a3412; }
.status-500 { background: #fee2e2; color: #991b1b; }

.response-time {
    color: #6b7280;
    font-size: 0.9rem;
}

.response-size {
    color: #6b7280;
    font-size: 0.9rem;
}

.response-actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    padding: 0.625rem 1.25rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    color: #374151;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn:hover {
    border-color: #ec4899;
    color: #ec4899;
    background: #fef3f8;
}

.response-body {
    padding: 2rem;
    max-height: 600px;
    overflow: auto;
    max-width: 100%;
    box-sizing: border-box;
}

.response-code {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.5rem;
    border-radius: 10px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
    overflow-x: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
    overflow-wrap: break-word;
    max-width: 100%;
    box-sizing: border-box;
}

/* Loading State */
.loading-overlay {
    text-align: center;
    padding: 4rem 2rem;
}

.loading-spinner {
    width: 60px;
    height: 60px;
    border: 5px solid #fce7f3;
    border-top-color: #ec4899;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1.5rem;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-text {
    color: #6b7280;
    font-size: 1.05rem;
    font-weight: 600;
}

/* Quick Templates */
.quick-templates {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

.template-card {
    padding: 1.25rem;
    background: linear-gradient(135deg, #fef3f8 0%, #fff 100%);
    border: 2px solid #fce7f3;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.template-card:hover {
    border-color: #ec4899;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(236, 72, 153, 0.15);
}

.template-method {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.template-title {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.template-desc {
    font-size: 0.85rem;
    color: #6b7280;
}

/* JSON Syntax Highlighting */
.json-key { color: #9cdcfe; }
.json-string { color: #ce9178; }
.json-number { color: #b5cea8; }
.json-boolean { color: #569cd6; }
.json-null { color: #569cd6; }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); padding: 2.5rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);">
                <h1 style="color: white; margin: 0; font-size: 2.25rem; font-weight: 700;">
                    <i class="fas fa-rocket"></i> FHIR API Explorer Pro
                </h1>
                <p style="color: rgba(255,255,255,0.95); margin: 0.75rem 0 0 0; font-size: 1.05rem;">
                    🔥 Postman-style interface untuk testing FHIR endpoints dengan HTTP methods, headers, dan body editor
                </p>
            </div>

            <!-- Quick Templates -->
            <div class="quick-templates">
                <h5 style="color: #ec4899; margin-bottom: 1.5rem; font-weight: 700;">
                    <i class="fas fa-bolt"></i> Quick Request Templates
                </h5>
                
                <div class="template-grid">
                    <div class="template-card" onclick="loadTemplate('get-patient')">
                        <span class="template-method method-GET" style="background: #d1fae5; color: #065f46;">GET</span>
                        <div class="template-title">Get Patient</div>
                        <div class="template-desc">Retrieve single patient by ID</div>
                    </div>
                    
                    <div class="template-card" onclick="loadTemplate('get-patients')">
                        <span class="template-method method-GET" style="background: #d1fae5; color: #065f46;">GET</span>
                        <div class="template-title">List Patients</div>
                        <div class="template-desc">Get all patients with pagination</div>
                    </div>
                    
                    <div class="template-card" onclick="loadTemplate('get-everything')">
                        <span class="template-method method-GET" style="background: #d1fae5; color: #065f46;">GET</span>
                        <div class="template-title">Patient $everything</div>
                        <div class="template-desc">Get complete patient data bundle</div>
                    </div>
                    
                    <div class="template-card" onclick="loadTemplate('get-appointments')">
                        <span class="template-method method-GET" style="background: #d1fae5; color: #065f46;">GET</span>
                        <div class="template-title">Get Appointments</div>
                        <div class="template-desc">Filter appointments by patient</div>
                    </div>
                </div>
            </div>

            <!-- Request Builder -->
            <div class="request-builder">
                <!-- Request Line -->
                <div class="request-header">
                    <div class="request-line">
                        <div class="method-selector">
                            <select id="httpMethod" class="method-select" onchange="updateMethodClass()">
                                <option value="GET" class="method-GET">GET</option>
                                <option value="POST" class="method-POST">POST</option>
                                <option value="PUT" class="method-PUT">PUT</option>
                                <option value="PATCH" class="method-PATCH">PATCH</option>
                                <option value="DELETE" class="method-DELETE">DELETE</option>
                            </select>
                        </div>
                        
                        <div class="url-input-group">
                            <div class="url-prefix">{{ url('/api/fhir') }}/</div>
                            <input type="text" id="endpoint" class="url-input" placeholder="Patient/1 or Patient?_count=10" value="Patient/1">
                        </div>
                        
                        <button onclick="sendRequest()" class="send-btn">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </div>

                <!-- Request Tabs -->
                <div class="request-tabs">
                    <button class="request-tab active" onclick="switchRequestTab('params')">
                        <i class="fas fa-cog"></i> Params <span class="badge" id="paramsCount">0</span>
                    </button>
                    <button class="request-tab" onclick="switchRequestTab('headers')">
                        <i class="fas fa-heading"></i> Headers <span class="badge" id="headersCount">2</span>
                    </button>
                    <button class="request-tab" onclick="switchRequestTab('body')">
                        <i class="fas fa-file-code"></i> Body
                    </button>
                </div>

                <!-- Params Tab -->
                <div id="params-tab" class="tab-panel active">
                    <h6 style="color: #6b7280; margin-bottom: 1.5rem; font-weight: 600;">Query Parameters</h6>
                    
                    <div class="kv-editor" id="paramsEditor">
                        <div class="kv-row">
                            <div style="grid-column: 1 / -1; color: #9ca3af; font-size: 0.9rem; padding: 1rem 0;">
                                <i class="fas fa-info-circle"></i> No query parameters yet. Click "Add Parameter" to add one.
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="addParam()" class="add-kv-btn">
                        <i class="fas fa-plus"></i> Add Parameter
                    </button>
                </div>

                <!-- Headers Tab -->
                <div id="headers-tab" class="tab-panel">
                    <h6 style="color: #6b7280; margin-bottom: 1.5rem; font-weight: 600;">Request Headers</h6>
                    
                    <div class="kv-editor" id="headersEditor">
                        <div class="kv-row">
                            <div class="kv-checkbox">
                                <input type="checkbox" checked data-header-enabled>
                            </div>
                            <input type="text" class="kv-input" value="Accept" data-header-key readonly>
                            <input type="text" class="kv-input" value="application/fhir+json" data-header-value>
                            <button class="kv-delete-btn" onclick="deleteHeader(this)" disabled>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="kv-row">
                            <div class="kv-checkbox">
                                <input type="checkbox" checked data-header-enabled>
                            </div>
                            <input type="text" class="kv-input" value="Content-Type" data-header-key readonly>
                            <input type="text" class="kv-input" value="application/json" data-header-value>
                            <button class="kv-delete-btn" onclick="deleteHeader(this)" disabled>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button onclick="addHeader()" class="add-kv-btn">
                        <i class="fas fa-plus"></i> Add Header
                    </button>
                </div>

                <!-- Body Tab -->
                <div id="body-tab" class="tab-panel">
                    <div class="body-type-selector">
                        <button class="body-type-btn active" onclick="selectBodyType('json')">
                            <i class="fas fa-code"></i> JSON
                        </button>
                        <button class="body-type-btn" onclick="selectBodyType('none')" disabled style="opacity: 0.5;">
                            <i class="fas fa-ban"></i> None
                        </button>
                    </div>
                    
                    <div class="body-editor">
                        <textarea id="bodyEditor" class="json-editor" placeholder='Enter JSON body here...

Example for creating a Patient:
{
  "resourceType": "Patient",
  "name": [{
    "use": "official",
    "family": "Doe",
    "given": ["John"]
  }]
}'></textarea>
                    </div>
                    
                    <div style="margin-top: 1rem; padding: 1rem; background: #fef3c7; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <strong style="color: #92400e;">⚠️ Note:</strong>
                        <span style="color: #78350f;"> Saat ini FHIR API hanya support GET (read-only). POST/PUT/DELETE akan available setelah write operations diimplementasikan.</span>
                    </div>
                </div>
            </div>

            <!-- Response Section -->
            <div id="responseSection" class="request-builder" style="display: none; margin-top: 2rem;">
                <div class="response-header">
                    <div class="response-meta">
                        <div id="statusBadge" class="status-badge status-200">200 OK</div>
                        <div class="response-time">
                            <i class="fas fa-clock"></i> <span id="responseTime">0ms</span>
                        </div>
                        <div class="response-size">
                            <i class="fas fa-weight"></i> <span id="responseSize">0 KB</span>
                        </div>
                    </div>
                    
                    <div class="response-actions">
                        <button onclick="copyResponse()" class="action-btn">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <button onclick="downloadResponse()" class="action-btn">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
                
                <div id="responseBody" class="response-body">
                    <div id="loadingState" class="loading-overlay" style="display: none;">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">Sending request...</div>
                    </div>
                    
                    <pre id="responseCode" class="response-code"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentResponse = null;
let requestStartTime = 0;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateMethodClass();
});

// Tab switching for request tabs
function switchRequestTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.request-tab').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.request-tab').classList.add('active');
    
    // Update tab panels
    document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
    document.getElementById(tabName + '-tab').classList.add('active');
}

// Update method selector class for color
function updateMethodClass() {
    const select = document.getElementById('httpMethod');
    const method = select.value;
    
    // Remove all method classes
    select.className = 'method-select';
    
    // Add current method class
    select.classList.add('method-' + method);
}

// Load request template
function loadTemplate(templateName) {
    const templates = {
        'get-patient': {
            method: 'GET',
            endpoint: 'Patient/1',
            params: [],
            headers: []
        },
        'get-patients': {
            method: 'GET',
            endpoint: 'Patient',
            params: [{ key: '_count', value: '10' }],
            headers: []
        },
        'get-everything': {
            method: 'GET',
            endpoint: 'Patient/1/$everything',
            params: [],
            headers: []
        },
        'get-appointments': {
            method: 'GET',
            endpoint: 'Appointment',
            params: [{ key: 'patient', value: '1' }],
            headers: []
        }
    };
    
    const template = templates[templateName];
    if (!template) return;
    
    // Set method
    document.getElementById('httpMethod').value = template.method;
    updateMethodClass();
    
    // Set endpoint
    document.getElementById('endpoint').value = template.endpoint;
    
    // Clear and set params
    clearParams();
    template.params.forEach(param => {
        addParam(param.key, param.value);
    });
}

// Parameters management
function addParam(key = '', value = '') {
    const editor = document.getElementById('paramsEditor');
    
    // Remove empty message if exists
    const emptyMsg = editor.querySelector('[style*="grid-column"]');
    if (emptyMsg) emptyMsg.parentElement.remove();
    
    const row = document.createElement('div');
    row.className = 'kv-row';
    row.innerHTML = `
        <div class="kv-checkbox">
            <input type="checkbox" checked data-param-enabled>
        </div>
        <input type="text" class="kv-input" placeholder="Key" value="${key}" data-param-key>
        <input type="text" class="kv-input" placeholder="Value" value="${value}" data-param-value>
        <button class="kv-delete-btn" onclick="deleteParam(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    editor.appendChild(row);
    updateParamsCount();
}

function deleteParam(btn) {
    btn.closest('.kv-row').remove();
    updateParamsCount();
    
    // Show empty message if no params
    const editor = document.getElementById('paramsEditor');
    if (editor.children.length === 0) {
        editor.innerHTML = `
            <div class="kv-row">
                <div style="grid-column: 1 / -1; color: #9ca3af; font-size: 0.9rem; padding: 1rem 0;">
                    <i class="fas fa-info-circle"></i> No query parameters yet. Click "Add Parameter" to add one.
                </div>
            </div>
        `;
    }
}

function clearParams() {
    const editor = document.getElementById('paramsEditor');
    editor.innerHTML = `
        <div class="kv-row">
            <div style="grid-column: 1 / -1; color: #9ca3af; font-size: 0.9rem; padding: 1rem 0;">
                <i class="fas fa-info-circle"></i> No query parameters yet. Click "Add Parameter" to add one.
            </div>
        </div>
    `;
    updateParamsCount();
}

function updateParamsCount() {
    const count = document.querySelectorAll('[data-param-enabled]:checked').length;
    document.getElementById('paramsCount').textContent = count;
}

// Headers management
function addHeader(key = '', value = '') {
    const editor = document.getElementById('headersEditor');
    
    const row = document.createElement('div');
    row.className = 'kv-row';
    row.innerHTML = `
        <div class="kv-checkbox">
            <input type="checkbox" checked data-header -enabled>
        </div>
        <input type="text" class="kv-input" placeholder="Key" value="${key}" data-header-key>
        <input type="text" class="kv-input" placeholder="Value" value="${value}" data-header-value>
        <button class="kv-delete-btn" onclick="deleteHeader(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    editor.appendChild(row);
    updateHeadersCount();
}

function deleteHeader(btn) {
    btn.closest('.kv-row').remove();
    updateHeadersCount();
}

function updateHeadersCount() {
    const count = document.querySelectorAll('[data-header-enabled]:checked').length;
    document.getElementById('headersCount').textContent = count;
}

// Body type selection
function selectBodyType(type) {
    document.querySelectorAll('.body-type-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}

// Send request
async function sendRequest() {
    const method = document.getElementById('httpMethod').value;
    const endpoint = document.getElementById('endpoint').value.trim();
    
    if (!endpoint) {
        alert('Please enter an endpoint');
        return;
    }
    
    // Show response section
    document.getElementById('responseSection').style.display = 'block';
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('responseCode').style.display = 'none';
    
    // Smooth scroll
    document.getElementById('responseSection').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Build URL with params
    let url = '{{ url("/api/fhir") }}/' + endpoint;
    const params = getActiveParams();
    if (params.length > 0 && !endpoint.includes('?')) {
        url += '?' + params.map(p => `${p.key}=${encodeURIComponent(p.value)}`).join('&');
    }
    
    // Build headers
    const headers = {};
    getActiveHeaders().forEach(h => {
        headers[h.key] = h.value;
    });
    
    // Build request options
    const options = {
        method: method,
        headers: headers
    };
    
    // Add body for POST/PUT/PATCH
    if (['POST', 'PUT', 'PATCH'].includes(method)) {
        const body = document.getElementById('bodyEditor').value.trim();
        if (body) {
            options.body = body;
        }
    }
    
    // Send request
    requestStartTime = Date.now();
    
    try {
        const response = await fetch(url, options);
        const responseTime = Date.now() - requestStartTime;
        const data = await response.json();
        const dataStr = JSON.stringify(data, null, 2);
        const dataSize = (new Blob([dataStr]).size / 1024).toFixed(2);
        
        currentResponse = data;
        
        // Update response metadata
        document.getElementById('statusBadge').textContent = `${response.status} ${response.statusText}`;
        document.getElementById('statusBadge').className = `status-badge status-${Math.floor(response.status / 100)}00`;
        document.getElementById('responseTime').textContent = `${responseTime}ms`;
        document.getElementById('responseSize').textContent = `${dataSize} KB`;
        
        // Show response
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('responseCode').style.display = 'block';
        document.getElementById('responseCode').textContent = dataStr;
        syntaxHighlight(document.getElementById('responseCode'));
        
    } catch (error) {
        const responseTime = Date.now() - requestStartTime;
        
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('responseCode').style.display = 'block';
        document.getElementById('responseCode').textContent = `Error: ${error.message}`;
        document.getElementById('statusBadge').textContent = 'ERROR';
        document.getElementById('statusBadge').className = 'status-badge status-500';
        document.getElementById('responseTime').textContent = `${responseTime}ms`;
    }
}

// Get active params
function getActiveParams() {
    const params = [];
    document.querySelectorAll('[data-param-enabled]:checked').forEach(checkbox => {
        const row = checkbox.closest('.kv-row');
        const key = row.querySelector('[data-param-key]').value.trim();
        const value = row.querySelector('[data-param-value]').value;
        if (key) {
            params.push({ key, value });
        }
    });
    return params;
}

// Get active headers
function getActiveHeaders() {
    const headers = [];
    document.querySelectorAll('[data-header-enabled]:checked').forEach(checkbox => {
        const row = checkbox.closest('.kv-row');
        const key = row.querySelector('[data-header-key]').value.trim();
        const value = row.querySelector('[data-header-value]').value;
        if (key) {
            headers.push({ key, value });
        }
    });
    return headers;
}

// Copy response
function copyResponse() {
    const text = JSON.stringify(currentResponse, null, 2);
    navigator.clipboard.writeText(text).then(() => {
        alert('✅ Response copied to clipboard!');
    });
}

// Download response
function downloadResponse() {
    const text = JSON.stringify(currentResponse, null, 2);
    const blob = new Blob([text], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `fhir-response-${Date.now()}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Syntax highlighting
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
</script>
@endsection
