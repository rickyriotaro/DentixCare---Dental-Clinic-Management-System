@extends('layouts.admin')
@section('title', 'Kelola Dokter')

@section('content')
<div class="page-header">
  <h2 class="page-title">Kelola Dokter</h2>
  <button class="btn-primary" onclick="openAddModal()">+ Tambah Dokter</button>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
  <table class="table-pink">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Dokter</th>
        <th>Email</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($dokters as $index => $d)
      <tr>
        <td>{{ $dokters->firstItem() + $index }}</td>
        <td>{{ $d->name }}</td>
        <td>{{ $d->email }}</td>
        <td>
          <button class="btn-ghost" onclick="openEditModal({{ $d->id }}, '{{ $d->name }}', '{{ $d->email }}')">Edit</button>
          <form method="POST" action="{{ route('dokters.destroy', $d->id) }}" style="display:inline;" onsubmit="return confirm('Yakin hapus dokter ini?')">
            @csrf
            @method('DELETE')
            <button class="btn-ghost" type="submit" style="color:#ef4444;">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" style="text-align:center; padding:18px;">Belum ada data dokter</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pager-wrap">
  {{ $dokters->onEachSide(0)->links('vendor.pagination.pink') }}
</div>

{{-- Modal Tambah --}}
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddModal()">&times;</span>
    <h3>Tambah Dokter Baru</h3>
    
    <form method="POST" action="{{ route('dokters.store') }}">
      @csrf
      <div class="form-row">
        <label>Nama Dokter</label>
        <input class="form-input" name="name" value="{{ old('name') }}" required>
        @error('name') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Email</label>
        <input class="form-input" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-row">
        <label>Password</label>
        <input class="form-input" type="password" name="password" required>
        @error('password') <small class="err">{{ $message }}</small> @enderror
      </div>

      <div class="form-actions">
        <button type="button" class="btn-ghost" onclick="closeAddModal()">Batal</button>
        <button type="submit" class="btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditModal()">&times;</span>
    <h3>Edit Dokter</h3>
    
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <div class="form-row">
        <label>Nama Dokter</label>
        <input class="form-input" id="edit_name" name="name" required>
      </div>

      <div class="form-row">
        <label>Email</label>
        <input class="form-input" type="email" id="edit_email" name="email" required>
      </div>

      <div class="form-row">
        <label>Password (Kosongkan jika tidak ingin diubah)</label>
        <input class="form-input" type="password" name="password">
      </div>

      <div class="form-actions">
        <button type="button" class="btn-ghost" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
}

.modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 30px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  position: relative;
}

.close {
  position: absolute;
  right: 20px;
  top: 15px;
  font-size: 28px;
  font-weight: bold;
  color: #aaa;
  cursor: pointer;
}

.close:hover {
  color: #000;
}

.modal h3 {
  margin-bottom: 20px;
  color: #1f2937;
}
</style>

<script>
function openAddModal() {
  document.getElementById('addModal').style.display = 'block';
}

function closeAddModal() {
  document.getElementById('addModal').style.display = 'none';
}

function openEditModal(id, name, email) {
  document.getElementById('editForm').action = '/dokters/' + id;
  document.getElementById('edit_name').value = name;
  document.getElementById('edit_email').value = email;
  document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
  const addModal = document.getElementById('addModal');
  const editModal = document.getElementById('editModal');
  if (event.target == addModal) {
    closeAddModal();
  }
  if (event.target == editModal) {
    closeEditModal();
  }
}

// Show modal if there are errors
@if($errors->any() && old('_method') == 'PUT')
  openEditModal({{ old('id') ?? 0 }}, '{{ old('name') }}', '{{ old('email') }}');
@elseif($errors->any())
  openAddModal();
@endif
</script>
@endsection
