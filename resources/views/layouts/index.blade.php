
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ env('APP_NAME') }}</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;900&display=swap"
    rel="stylesheet">

  <!-- 
    - material icon link
  -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    rel="stylesheet" />

    {{--  bootsrtap  --}}
{{--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">  --}}

{{--  Bootstrap  --}}
  {{--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">  --}}
</head>

<body>

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <h1>
        <a href="#" class="logo">{{ env('APP_NAME') }}</a>
      </h1>

      <button class="menu-toggle-btn icon-box" data-menu-toggle-btn aria-label="Toggle Menu">
        <span class="material-symbols-rounded  icon">menu</span>
      </button>

      <nav class="navbar">
        <div class="container">

          <ul class="navbar-list">

            <li>
              <a href="#" class="navbar-link active icon-box">
                <span class="material-symbols-rounded  icon">grid_view</span>

                <span>Home</span>
              </a>
            </li>

            <li>
              <a href="{{ route('jenis-surat.index') }}" class="navbar-link icon-box">
                {{--  <span class="material-symbols-rounded  icon">folder</span>  --}}
                <span class="material-symbols-rounded  icon">list</span>

                <span>Jenis Surat</span>
              </a>
            </li>

            <li>
              <a href="{{ route('surat.index') }}" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">files</span>

                <span>Surat</span>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">bar_chart</span>

                <span>Reports</span>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-link icon-box">
                <span class="material-symbols-rounded  icon">settings</span>

                <span>Settings</span>
              </a>
            </li>

          </ul>

          <ul class="user-action-list">

            <li>
              <a href="#" class="notification icon-box">
                <span class="material-symbols-rounded  icon">notifications</span>
              </a>
            </li>

            <li>
              <a href="#" class="header-profile">

                <figure class="profile-avatar">
                  <img src="./assets/images/avatar-1.jpg" alt="Elizabeth Foster" width="32" height="32">
                </figure>

                <div>
                  <p class="profile-title">Elizabeth F</p>

                  <p class="profile-subtitle">Admin</p>
                </div>

              </a>
            </li>

          </ul>

        </div>
      </nav>

    </div>
  </header>





  <main>
    @yield('content')
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="container">

      {{--  <ul class="footer-list">  --}}

        {{--  <li class="footer-item">
          <a href="#" class="footer-link">About</a>
        </li>

        <li class="footer-item">
          <a href="#" class="footer-link">Privacy</a>
        </li>

        <li class="footer-item">
          <a href="#" class="footer-link">Terms</a>
        </li>

        <li class="footer-item">
          <a href="#" class="footer-link">Developers</a>
        </li>

        <li class="footer-item">
          <a href="#" class="footer-link">Support</a>
        </li>

        <li class="footer-item">
          <a href="#" class="footer-link">Careers</a>
        </li>  --}}

      {{--  </ul>  --}}

      {{--  <p class="copyright">
        &copy; 2022 <a href="#" class="copyright-link">codewithsadee</a>. All Rights Reserved
      </p>  --}}

      <p>&copy; <b id="year"></b> <b>Surat.</b> All rights reserved.</p>

    </div>
  </footer>



{{--  Boostrap  --}}
{{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>  --}}


  <!-- 
    - custom js link
  -->
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
  </script>

  @stack('scripts')
</body>

</html>