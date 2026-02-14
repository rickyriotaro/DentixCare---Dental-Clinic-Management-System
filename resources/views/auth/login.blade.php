<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Klinik</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="login-page">
  <div class="login-wrap">
    <div class="login-card">

      <!-- KIRI -->
      <div class="login-left">
        <h2 class="login-title">Wujudkan Senyum Indah Bersama drg.Femmy</h2>

        {{-- Error login --}}
        @if ($errors->any())
          <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
          @csrf

          {{-- PILIH ROLE --}}
          <div class="group">
            <span class="label">Login Sebagai</span>

            <div class="role-wrap">
              <label class="role-pill">
                <input type="radio" name="role" value="admin" {{ old('role','admin') === 'admin' ? 'checked' : '' }}>
                <span>Admin</span>
              </label>

              <label class="role-pill">
                <input type="radio" name="role" value="dokter" {{ old('role') === 'dokter' ? 'checked' : '' }}>
                <span>Dokter</span>
              </label>
            </div>

            @error('role')
              <small class="err">{{ $message }}</small>
            @enderror
          </div>

          <div class="group">
            <span class="label">Email</span>
            <input class="input" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
              <small class="err">{{ $message }}</small>
            @enderror
          </div>

          <div class="group">
            <span class="label">Password</span>
            <input class="input" type="password" name="password" required>
            @error('password')
              <small class="err">{{ $message }}</small>
            @enderror
          </div>

          <div class="row">
            <label style="display:flex; align-items:center; gap:8px;">
              <input type="checkbox" required>
              Setuju dengan syarat dan ketentuan
            </label>

            <a class="link" href="#" onclick="alert('Fitur lupa password belum dibuat'); return false;">
              Lupa Password?
            </a>
          </div>

          <button class="btn" type="submit">Login</button>
        </form>
      </div>

      <!-- KANAN -->
      <div class="login-right">
        <div>
          <img class="tooth" src="{{ asset('images/logo-klinik.png') }}" alt="Logo Klinik">
        </div>
      </div>

    </div>
  </div>
</body>
</html>
