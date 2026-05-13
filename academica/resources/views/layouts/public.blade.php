<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HidroVida')</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>

    <style>
        :root {
            --primary-dark: #1b3650;
            --primary-light: #299bc4;
            --accent-teal: #2cc0b3;
            --alert-red: #ff5a5f;
            --text-dark: #163f5c;
            --bg-color: #eef8fb; 
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Layout */
        .header {
            background-color: #6fa1c0;
            color: white;
            padding: 1.2rem 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1;
            text-decoration: none;
            color: white;
        }
        .header-logo:hover { color: #e0f2fe; }
        .header-logo i { font-size: 2.2rem; margin-bottom: 2px; }
        .header-logo span { font-size: 1.4rem; font-weight: 800; letter-spacing: 0.5px; }

        .header-nav {
            display: flex;
            gap: 2.5rem;
            margin-left: 2rem;
        }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            opacity: 0.8;
            transition: all 0.3s ease;
            gap: 0.3rem;
        }
        .nav-item i, .nav-item svg { font-size: 1.5rem; width: 24px; height: 24px; }
        .nav-item:hover, .nav-item.active { opacity: 1; color: white; transform: translateY(-2px); }

        /* Footer */
        .custom-footer {
            background-color: #729fba;
            color: white;
            padding: 4rem 0 2rem;
            margin-top: auto;
        }
        .footer-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1;
            margin-bottom: 1rem;
            color: white;
            text-decoration: none;
        }
        .footer-logo i { font-size: 2.5rem; }
        .footer-logo span { font-size: 1.5rem; font-weight: 800; }
        .footer-logo-desc { font-size: 0.85rem; opacity: 0.9; }
        .custom-footer h5 { font-weight: 700; margin-bottom: 1.2rem; font-size: 1.1rem; }
        .custom-footer ul { list-style: none; padding: 0; margin: 0; }
        .custom-footer ul li { margin-bottom: 0.5rem; }
        .custom-footer ul li a { color: white; text-decoration: none; opacity: 0.9; font-size: 0.9rem; }
        .custom-footer ul li a:hover { opacity: 1; text-decoration: underline; }
        .social-links { display: flex; flex-direction: column; gap: 1rem; }
        .social-link { color: white; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; font-size: 0.9rem; opacity: 0.9; }
        .social-link:hover { opacity: 1; }
        .copyright { text-align: center; margin-top: 3rem; font-size: 0.8rem; opacity: 0.7; }

        @media (max-width: 768px) {
            .header { flex-direction: column; gap: 1rem; padding: 1rem; }
            .header-nav { margin-left: 0; gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .custom-footer .row > div { margin-bottom: 2rem; text-align: center; }
            .footer-logo { align-items: center; }
        }

        @yield('styles')
    </style>
</head>
<body>
    <div id="appSistema" style="display: flex; flex-direction: column; min-height: 100vh;">
        
        <header class="header">
            <a href="/" class="header-logo">
                <img src="{{ asset('img/logo_hidrovida.png') }}" alt="HidroVida Logo" style="height: 50px; width: auto;">
            </a>
            
            <nav class="header-nav">
                <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Inicio</span>
                </a>
                <a href="/calidad" class="nav-item {{ request()->is('calidad') ? 'active' : '' }}">
                    <i class="bi bi-droplet-fill"></i>
                    <span>Calidad</span>
                </a>
                <a href="/reportar" class="nav-item {{ request()->is('reportar') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4a5 5 0 0 0-5 5v3H5v4h14v-4h-2V9a5 5 0 0 0-5-5zm-3 8V9a3 3 0 0 1 6 0v3H9zm-2 6h10v2H7v-2zm5-16h-4v2h4V2z"/>
                    </svg>
                    <span>Reportes</span>
                </a>
                <a href="/alertas" class="nav-item {{ request()->is('alertas') ? 'active' : '' }}">
                    <i class="bi bi-bell-fill"></i>
                    <span>Alertas</span>
                </a>
                <a href="/estandares" class="nav-item {{ request()->is('estandares') ? 'active' : '' }}">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Informacion</span>
                </a>
            </nav>

        @if(session()->has('usuario_nombre'))
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                @if(session()->has('admin_id'))
                <a href="#" @click.prevent="abrirVentana('sensores')" class="nav-item" style="color: #f1c40f;">
                    <i class="bi bi-sliders"></i>
                    <span>Panel</span>
                </a>
                @endif
                <span style="color: white; font-weight: 600; font-size: 0.95rem;">
                    <i class="bi bi-person-circle"></i> {{ ucfirst(session('usuario_nombre')) }}
                </span>
                <a href="/logout" class="nav-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Salir</span>
                </a>
            </div>
        @else
            <a href="/login" class="nav-item">
                <i class="bi bi-person-fill"></i>
                <span>Iniciar sesión</span>
            </a>
        @endif
        </header>

        
        <main class="container flex-grow-1 py-4" style="padding-bottom: 4rem;">
            @yield('content')
            
            
            <div class="vue-components-wrapper">
                <pagos @buscar='buscar("buscar_pagos","obtenerPagos")' :forms="forms" ref="pagos" v-show="forms.pagos.mostrar"></pagos>
                <buscar_pagos @modificar='modificar("pagos","modificarPago", $event)' :forms="forms" ref="buscar_pagos" v-show="forms.buscar_pagos.mostrar"></buscar_pagos>

                <reportes @buscar='buscar("buscar_reportes","obtenerReportes")' :forms="forms" ref="reportes" v-show="forms.reportes.mostrar"></reportes>
                <buscar_reportes @modificar='modificar("reportes","modificarReporte", $event)' :forms="forms" ref="buscar_reportes" v-show="forms.buscar_reportes.mostrar"></buscar_reportes>

                
                <sensores :forms="forms" ref="sensores" v-show="forms.sensores.mostrar"></sensores>
            </div>
        </main>
        
        
        <footer class="custom-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/" class="footer-logo">
                            <img src="{{ asset('img/logo_hidrovida.png') }}" alt="HidroVida Logo" style="height: 60px; width: auto; object-fit: contain;">
                        </a>
                        <p class="footer-logo-desc">Comprometidos con la calidad del agua y bienestar de nuestra comunidad</p>
                    </div>
                    <div class="col-md-3">
                        <h5>Enlaces rápidos</h5>
                        <ul>
                            <li><a href="/">Inicio</a></li>
                            <li><a href="/calidad">Calidad de agua</a></li>
                            <li><a href="/reportar">Reportes</a></li>
                            <li><a href="/alertas">Alertas</a></li>
                            <li><a href="/estandares">Información</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Soporte</h5>
                        <ul>
                            <li><a href="#">Centro de ayuda</a></li>
                            <li><a href="#">Preguntas frecuentes</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Términos de uso</a></li>
                            <li><a href="#">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h5>Síguenos</h5>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="bi bi-facebook"></i> HidroVida.sv</a>
                            <a href="#" class="social-link"><i class="bi bi-instagram"></i> @hidrovida.sv</a>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    &copy; 2026 HidroVida. Todos los derechos reservados.
                </div>
            </div>
        </footer>
    </div>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
