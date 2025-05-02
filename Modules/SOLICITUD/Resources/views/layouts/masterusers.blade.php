<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('AdminLTE/dist/img/logos.gif') }}" type="image/x-icon">
    <title>Sistema de Solicitud de Materiales</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@400;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #1a252f;
            --accent-color: #218838;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            margin-bottom: 30px;
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .feature-box {
            background: white;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border-top: 4px solid var(--accent-color);
        }
        
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: #2980b9;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 20px 0;
        }
        
        .display-4 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .lead {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 30px;
        }
        
        .cta-section {
            background-color: var(--primary-color);
            color: white;
            padding: 70px 0;
        }
        
        .stats-box {
            background: white;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 10px;
        }
        
        .process-step {
            position: relative;
            padding-left: 80px;
            margin-bottom: 40px;
        }
        
        .step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark">
        <a class="navbar-brand mx-auto mx-md-0" href="#">
            <i class="fas fa-clipboard-check mr-2"></i>Solicitud de Materiales
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Inicio</a>
            </li>
            @auth
                @if(checkRol('solicitud.admin'))
                    <li class="nav-item">
                        <a href="{{ route('solicitud.admin.welcome') }}" 
                           class="nav-link @if(Route::is('solicitud.admin.*')) active @endif">
                            <i class="fas fa-user-shield mr-1"></i>Administrador
                        </a>
                    </li>
                @endif
                @if(checkRol('solicitud.store'))
                    <li class="nav-item">
                        <a href="{{ route('solicitud.store.welcome') }}" 
                           class="nav-link @if(Route::is('solicitud.store.*')) active @endif">
                            <i class="fas fa-user-shield mr-1"></i>Intructor
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4">Gestión Eficiente de Solicitudes de Materiales</h1>
            <p class="lead">
                Optimiza el proceso de solicitud, aprobación y distribución de materiales en tu organización. 
                Reduce tiempos de espera y mejora la trazabilidad de cada requerimiento.
            </p>
            <div class="mt-4">
                @auth
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mr-3">
                        <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle mr-2"></i>Más Información
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container my-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="mb-3">Beneficios Clave</h2>
                <p class="lead">Descubre cómo nuestro sistema transformará tu proceso de solicitudes</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3>Solicitudes Rápidas</h3>
                    <p>Envía solicitudes de materiales en minutos con nuestro formulario intuitivo y campos predefinidos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <h3>Aprobaciones Ágiles</h3>
                    <p>Flujo de aprobación configurable con notificaciones en tiempo real para los responsables.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3>Reportes Detallados</h3>
                    <p>Genera informes de consumo, tiempos de respuesta y análisis de tendencias de solicitudes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="container my-5 py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="mb-3">¿Cómo Funciona?</h2>
                <p class="lead">Un proceso simple en solo 4 pasos</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h3>Registro de Solicitud</h3>
                    <p>Completa el formulario con los materiales requeridos, cantidades y prioridad. Adjunta documentos si es necesario.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h3>Revisión y Aprobación</h3>
                    <p>El sistema notifica automáticamente a los aprobadores designados para su revisión y validación.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h3>Procesamiento</h3>
                    <p>Una vez aprobada, la solicitud se deriva al área de compras o almacén para su preparación.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h3>Entrega y Confirmación</h3>
                    <p>Notificación al solicitante cuando los materiales están disponibles para retiro o han sido entregados.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="container my-5 py-5">
        <div class="row">
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">75%</div>
                    <h4>Reducción en tiempos</h4>
                    <p>De procesamiento de solicitudes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">100%</div>
                    <h4>Trazabilidad</h4>
                    <p>De cada solicitud y sus movimientos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">24/7</div>
                    <h4>Disponibilidad</h4>
                    <p>Acceso al sistema en cualquier momento</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="stats-number">95%</div>
                    <h4>Satisfacción</h4>
                    <p>De usuarios con el proceso digital</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center">
        <div class="container">
            <h2 class="mb-4">¿Listo para optimizar tu proceso de solicitudes?</h2>
            <p class="lead mb-5">Únete a las organizaciones que ya están transformando su gestión de materiales</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg mr-3">
                <i class="fas fa-play-circle mr-2"></i>Ver Demo
            </a>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus mr-2"></i>Registrarse
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-left mb-3 mb-md-0">
                    <strong>Copyright &copy; 2023-2025 <a href="#" style="color: var(--accent-color);">Sistema de Solicitudes</a>.</strong> Todos los derechos reservados.
                </div>
                <div class="col-md-6 text-md-right">
                    <b>Versión</b> 3.2.0 | <a href="#" style="color: #aaa;">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>
</body>
</html>