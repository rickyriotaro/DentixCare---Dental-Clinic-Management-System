@extends('layouts.admin')

@section('title', 'FHIR Explorer')

@section('content')
<style>
/* Tab System */
.tab-nav {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    border-bottom: 2px solid #fce7f3;
}

.tab-btn {
    padding: 1rem 2rem;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: #9ca3af;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.tab-btn:hover {
    color: #ec4899;
    background: rgba(236, 72, 153, 0.05);
}

.tab-btn.active {
    color: #ec4899;
    border-bottom-color: #ec4899;
}

.tab-btn i {
    margin-right: 0.5rem;
}

.tab-content {
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Parameter Builder Styles */
.param-form {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.param-group {
    margin-bottom: 1.5rem;
}

.param-label {
    display: block;
    color: #374151;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.param-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.param-input, .param-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #fce7f3;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.param-input:focus, .param-select:focus {
    outline: none;
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

.param-checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.param-checkbox {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #fce7f3;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.param-checkbox:hover {
    background: #fbcfe8;
}

.param-checkbox input[type="checkbox"] {
    margin-right: 0.5rem;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.url-preview {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.5rem;
    border-radius: 10px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    overflow-x: auto;
    margin: 1.5rem 0;
    border: 2px solid #ec4899;
}

.url-preview .method {
    color: #10b981;
    font-weight: bold;
    margin-right: 1rem;
}

.url-preview .url {
    color: #60a5fa;
}

.execute-btn {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.execute-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(236, 72, 153, 0.3);
}

.execute-btn:active {
    transform: translateY(0);
}

.resource-type-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.resource-card {
    padding: 1rem;
    background: white;
    border: 2px solid #fce7f3;
    border-radius: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.resource-card:hover {
    border-color: #ec4899;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(236, 72, 153, 0.2);
}

.resource-card.active {
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    border-color: #ec4899;
}

.resource-card i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.resource-card span {
    font-weight: 600;
    font-size: 0.9rem;
}

.info-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 20px;
    font-size: 0.85rem;
    margin-left: 0.5rem;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header" style="background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
                <h1 style="color: white; margin: 0; font-size: 2rem; font-weight: 600;">
                    <i class="fas fa-server"></i> FHIR API Explorer
                </h1>
                <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">
                    Test & explore FHIR endpoints directly from your browser
                </p>
            </div>

            <!-- Quick Access Buttons -->
            <div class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                <div class="card-body" style="padding: 2rem;">
                    <h5 style="color: #ec4899; margin-bottom: 1.5rem; font-weight: 600;">
                        <i class="fas fa-rocket"></i> Quick Endpoints
                    </h5>
                    
                    <div class="row g-3">
                        <!-- Metadata -->
                        <div class="col-md-4">
                            <button class="endpoint-btn" onclick="loadEndpoint('metadata')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-info-circle"></i> Server Capabilities
                                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/metadata</div>
                            </button>
                        </div>

                        <!-- All Patients -->
                        <div class="col-md-4">
                            <button class="endpoint-btn" onclick="loadEndpoint('Patient?_count=10')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-users"></i> All Patients (10)
                                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient?_count=10</div>
                            </button>
                        </div>

                        <!-- Patient Everything -->
                        <div class="col-md-4">
                            <button class="endpoint-btn" onclick="loadEndpoint('Patient/1/$everything')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-database"></i> Patient Everything
                                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient/1/$everything</div>
                            </button>
                        </div>

                        <!-- Single Patient -->
                        <div class="col-md-4">
                            <button class="endpoint-btn" onclick="loadEndpoint('Patient/1')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-user"></i> Single Patient
                                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Patient/1</div>
                            </button>
                        </div>

                        <!-- Appointments -->
                        <div class="col-md-4">
                            <button class="endpoint-btn" onclick="loadEndpoint('Appointment?patient=1')" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-calendar"></i> Appointments
                                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.5rem;">/fhir/Appointment?patient=1</div>
                            </button>
                        </div>

                        <!-- Conditions -->
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

            <!-- Response -->
            <div id="responseCard" class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: none;">
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

function loadEndpoint(endpoint) {
    const responseCard = document.getElementById('responseCard');
    const loading = document.getElementById('loading');
    const responseContent = document.getElementById('responseContent');
    const statusBadge = document.getElementById('statusBadge');
    
    // Show loading
    responseCard.style.display = 'block';
    loading.style.display = 'block';
    responseContent.style.display = 'none';
    
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

// Allow Enter key on custom endpoint input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('customEndpoint').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            loadCustomEndpoint();
        }
    });
});
</script>
@endsection
