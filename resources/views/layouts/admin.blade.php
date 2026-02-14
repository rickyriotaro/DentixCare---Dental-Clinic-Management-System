<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin')</title>

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
        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
        href="{{ route('dashboard') }}">
        <span class="dot"><i class="fa-solid fa-grip"></i></span>
        Dashboard
        </a>

        <a class="{{ request()->routeIs('patients.*') ? 'active' : '' }}"
         href="{{ route('patients.index') }}">
        <span class="dot"><i class="fa-regular fa-user"></i></span>
        Data Pasien
        </a>

        <a class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}"
           href="{{ route('appointments.index') }}">
        <span class="dot"><i class="fa-regular fa-calendar"></i></span>
        Jadwal Janji Temu
        </a>

        <a class="{{ request()->routeIs('rekammedis.*') ? 'active' : '' }}"
        href="{{ route('rekammedis.index') }}">
        <span class="dot"><i class="fa-regular fa-file-lines"></i></span>
        Data Rekam Medis
        </a>

        <a class="{{ request()->routeIs('dokters.*') ? 'active' : '' }}"
        href="{{ route('dokters.index') }}">
        <span class="dot"><i class="fa-solid fa-user-doctor"></i></span>
        Kelola Dokter
        </a>
        
        <a class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"
        href="{{ route('notifications.index') }}">
        <span class="dot"><i class="fa-regular fa-bell"></i></span>
        Pemberitahuan
        </a>

        <a class="{{ request()->routeIs('reports.visits.*') ? 'active' : '' }}"
        href="{{ route('reports.visits.index') }}">
        <span class="dot"><i class="fa-regular fa-file"></i></span>
         Laporan Kunjungan
        </a>

        <a class="{{ request()->routeIs('fhir.explorer') ? 'active' : '' }}"
        href="{{ route('fhir.explorer') }}">
        <span class="dot"><i class="fa-solid fa-server"></i></span>
         FHIR Explorer
        </a>

        {{-- TODO: Uncomment when FinancialReportController is created
        <a class="{{ request()->routeIs('reports.financial.*') ? 'active' : '' }}"
        href="{{ route('reports.financial.index') }}">
        <span class="dot"><i class="fa-solid fa-money-bill-wave"></i></span>
         Laporan Keuangan
        </a>
        --}}
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
