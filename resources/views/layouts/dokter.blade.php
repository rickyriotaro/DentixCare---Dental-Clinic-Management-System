<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dokter')</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="dashboard-page">
  <div class="app">

    <aside class="sidebar">
      <div class="logo">
        <img src="{{ asset('images/logo-klinik.png') }}" alt="Logo Klinik">
      </div>

      <nav class="nav">
        <a class="{{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}"
           href="{{ route('dokter.dashboard') }}">
          <span class="dot"><i class="fa-solid fa-grip"></i></span>
          Dashboard
        </a>

        <a class="{{ request()->routeIs('dokter.appointments.*') ? 'active' : '' }}"
           href="{{ route('dokter.appointments.index') }}">
          <span class="dot"><i class="fa-regular fa-calendar"></i></span>
          Jadwal Janji Temu
        </a>

        <a class="{{ request()->routeIs('dokter.rekammedis.*') ? 'active' : '' }}"
        href="{{ route('dokter.rekammedis.index') }}">
        <span class="dot"><i class="fa-regular fa-file-lines"></i></span>
        Data Rekam Medis
        </a>

        <!--<a class="{{ request()->routeIs('dokter.riwayat.*') ? 'active' : '' }}"
        href="{{ route('dokter.riwayat.index') }}">
        <span class="dot"><i class="fa-regular fa-clock"></i></span>
        Riwayat Perawatan
       </a>-->

        <a class="{{ request()->routeIs('dokter.rekammedis.*') ? 'active' : '' }}"
        href="{{ route('dokter.perawatan.index') }}">
       <span class="dot"><i class="fa-regular fa-file"></i></span>
          Rencana Perawatan Gigi
        </a>

        <a class="{{ request()->routeIs('dokter.kontrol.*') ? 'active' : '' }}"
        href="{{ route('dokter.kontrol.index') }}">
        <span class="dot"><i class="fa-regular fa-clipboard"></i></span>
        Kontrol Pasien
      </a>
      </nav>
    </aside>

    <main class="main">
      <div class="topbar">
        <div style="display:flex;align-items:center;gap:10px;">
          <div class="avatar"></div>
          <div class="username">Hi, {{ auth()->user()->name }}</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout" type="submit" title="Logout">↩</button>
        </form>
      </div>
      @yield('content')
    </main>

  </div>
</body>
</html>
