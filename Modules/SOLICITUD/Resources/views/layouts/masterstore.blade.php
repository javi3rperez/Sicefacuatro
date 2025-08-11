<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('AdminLTE/dist/img/logos.gif')}}" type="image/x-icon">
    <title>Gestión de Solicitudes</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="{{ asset('AdminLTE/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-- Custom styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-bUGl5l+WrFj8h2QZBqzdrzzOyBGJgqEiXfRDAjC6M9uSNGBqZrG7KoQqxXONwbTuHYDlmJ8jthEnZz7j8P4X2g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --dark-color: #343a40;
            --light-color: #ffffff;
        }
        
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        
        .brand-link {
            background: linear-gradient(135deg, var(--primary-color), #218838) !important;
        }
        
        .brand-text {
            color: var(--light-color) !important;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: rgba(40, 167, 69, 0.2);
            border-left: 4px solid var(--primary-color);
        }
        
        .nav-link {
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            transform: translateX(5px);
        }
        
        .main-header {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .preloader img {
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .content-wrapper {
            background-color: #f5f7fa;
        }
        
        footer.main-footer {
            background: linear-gradient(to right, var(--dark-color), #23272b) !important;
            color: white;
            padding: 12px 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        
        .user-panel {
            background: rgba(40, 167, 69, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin: 0 10px;
        }
        
        .nav-sidebar .nav-item > .nav-link {
            border-radius: 4px;
            margin: 2px 8px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        /* Estilos para los checkboxes del menú */
        .menu-checkbox {
            margin-right: 8px;
        }
        
        .menu-checkbox:checked {
            accent-color: var(--primary-color);
        }
        
        .menu-item-text {
            vertical-align: middle;
        }
    </style>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__pulse" src="{{ asset('AdminLTE/dist/img/solicitud.png') }}" alt="Logo s" height="160" width="160">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars" style="color: var(--primary-color)"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    
                <a href="#" class="nav-link" style="color: var(--primary-color); font-weight: 600;">
    <i class="fas fa-home nav-icon mr-1"></i>
</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle text-success"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt text-success"></i> Cerrar Sesión
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #ffffff; border-right: 1px solid #eaeaea;">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link" style="text-decoration:none">
                <img src="{{ asset('AdminLTE/dist/img/logos.gif') }}" alt="Logo"
                    class="brand-image" style="opacity: .9">
                <span class="brand-text font-weight-light" >Solicitudes</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('solicitud.store.list') }}" class="nav-link" style="color: var(--dark-color);">
                                <i class="nav-icon fas fa-list" style="color: var(--primary-color);"></i>
                                <p>Listado de solicitudes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitud.store.inventory') }}" class="nav-link" style="color: var(--dark-color);">
                                <i class="nav-icon fas fa-boxes" style="color: var(--primary-color);"></i>
                                <p>Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitud.store.movements') }}" class="nav-link" style="color: var(--dark-color);">
                                <i class="nav-icon fas fa-random" style="color: var(--primary-color);"></i>
                                <p>Entrada y Salidas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitud.store.evidence') }}" class="nav-link" style="color: var(--dark-color);">
                                <i class="nav-icon fas fa-plus-circle" style="color: var(--primary-color);"></i>
                                <p>Evidencia de Entrega</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper" style="background-color: #f8f9fa;">
            @yield('content')
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>&copy; 2023-2025 <a href="#" style="color: #6c757d;">Solicitudes</a>.</strong> Todos los derechos reservados.
                    </div>
                    <div class="col-sm-6 text-right d-none d-sm-block">
                        <b>Versión</b> 3.2.0 | <span id="current-date"></span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>
    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('AdminLTE/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('AdminLTE-/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo -->
    <script src="{{ asset('AdminLTE/dist/js/pages/dashboard2.js') }}"></script>
    
    <!-- Custom Script -->
    <script>
        // Mostrar fecha actual en el footer
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Animación para elementos del menú
        $(document).ready(function() {
            $('.nav-link').hover(
                function() {
                    $(this).css('transform', 'translateX(5px)');
                },
                function() {
                    $(this).css('transform', 'translateX(0)');
                }
            );
        });
    </script>
</body>

</html>