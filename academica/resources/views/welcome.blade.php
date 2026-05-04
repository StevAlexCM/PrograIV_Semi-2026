<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HidroVida - Panel Principal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AlertifyJS (kept from original) -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>

    <style>
        :root {
            --primary-dark: #1b3650;
            --primary-light: #2099c2;
            --accent-teal: #2cc0b3;
            --card-bg: #bcd0de;
            --gauge-green: #2ebc2e;
            --gauge-yellow: #f1c40f;
            --gauge-red: #e74c3c;
            --text-dark: #163f5c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #ffffff;
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
        }

        /* Header Layout */
        .header {
            background-color: var(--primary-dark);
            color: white;
            padding: 0.8rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1;
            text-decoration: none;
            color: white;
        }
        .header-logo:hover {
            color: #e0f2fe;
        }
        .header-logo i {
            font-size: 2.2rem;
            margin-bottom: 2px;
        }
        .header-logo span {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

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
        .nav-item i, .nav-item svg {
            font-size: 1.5rem;
            width: 24px;
            height: 24px;
        }
        .nav-item:hover, .nav-item.active {
            opacity: 1;
            color: white;
            transform: translateY(-2px);
        }

        .btn-register {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 4rem 1rem 2rem;
            animation: fadeIn 0.8s ease-out;
        }
        .hero-title {
            color: var(--text-dark);
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1.2rem;
            line-height: 1.2;
        }
        .hero-subtitle {
            color: var(--primary-light);
            font-size: 1.05rem;
            font-weight: 600;
            max-width: 650px;
            margin: 0 auto 1.8rem auto;
            line-height: 1.6;
        }
        .btn-primary-custom {
            background-color: var(--text-dark);
            color: white;
            border: none;
            padding: 0.7rem 1.8rem;
            border-radius: 25px;
            font-size: 0.95rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(22, 63, 92, 0.2);
        }
        .btn-primary-custom:hover {
            background-color: #123456;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(22, 63, 92, 0.3);
        }

        /* Gauge Panel */
        .gauge-section {
            text-align: center;
            margin: 3rem 0;
            animation: slideUp 0.8s ease-out 0.2s both;
        }
        .gauge-title {
            color: var(--accent-teal);
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
        }
        .gauge {
            width: 340px;
            height: 170px;
            background: conic-gradient(from 270deg at 50% 100%, 
                var(--gauge-green) 0deg, 
                var(--gauge-green) 100deg, 
                var(--gauge-yellow) 100deg, 
                var(--gauge-yellow) 140deg, 
                var(--gauge-red) 140deg, 
                var(--gauge-red) 180deg, 
                transparent 180deg);
            border-radius: 170px 170px 0 0;
            margin: 0 auto;
            position: relative;
        }
        .gauge-inner {
            width: 270px;
            height: 135px;
            background-color: #ffffff;
            border-radius: 135px 135px 0 0;
            position: absolute;
            bottom: 0;
            left: 35px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 0.8rem;
        }
        .gauge-icon {
            color: var(--accent-teal);
            font-size: 3.5rem;
            margin-bottom: -5px;
        }
        .gauge-text {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }
        .gauge-status {
            color: var(--accent-teal);
            font-size: 1.3rem;
            font-weight: 800;
        }

        /* Info Cards */
        .cards-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.5rem 4rem;
            animation: slideUp 0.8s ease-out 0.4s both;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8rem;
            margin-bottom: 1.8rem;
        }
        .info-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-5px);
        }
        .info-card .icon-wrapper {
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }
        .info-card h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .info-card .highlight {
            color: var(--accent-teal);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }
        .info-card .muted {
            font-size: 0.8rem;
            color: var(--text-dark);
            font-weight: 600;
            margin: 0;
            opacity: 0.8;
        }

        /* Action Card (Full Width) */
        .action-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-column: 1 / -1;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-5px);
        }
        .action-card-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .btn-teal {
            background-color: var(--accent-teal);
            color: white;
            border: none;
            padding: 0.7rem 1.4rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(44, 192, 179, 0.3);
        }
        .btn-teal:hover {
            background-color: #24a89d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(44, 192, 179, 0.4);
        }

        /* Bottom Banner */
        .bottom-banner {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .bottom-banner .banner-text {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-dark);
        }
        .bottom-banner .banner-text i {
            color: var(--accent-teal);
            font-size: 1.4rem;
        }
        .bottom-banner .banner-link {
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s;
        }
        .bottom-banner .banner-link:hover {
            color: var(--primary-light);
        }
        
        /* Vue Components Container */
        .vue-components-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            .header-nav {
                margin-left: 0;
                gap: 1.5rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            .cards-grid {
                grid-template-columns: 1fr;
            }
            .action-card {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            .action-card-left {
                flex-direction: column;
            }
            .bottom-banner {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div id="appSistema">
        <!-- Header -->
        <header class="header">
            <a href="#" class="header-logo">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-5.5c-.5 1.5-2 3.9-4 5.5S5 13 5 15a7 7 0 0 0 7 7z"></path>
                    <path d="M12 18a3 3 0 0 0 3-3c0-1.5-1.5-3-3-4.5-1.5 1.5-3 3-3 4.5a3 3 0 0 0 3 3z"></path>
                </svg>
                <span>HidroVida</span>
            </a>
            
            <nav class="header-nav">
                <a href="#" class="nav-item active">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Inicio</span>
                </a>
                <a href="/calidad" class="nav-item">
                    <i class="bi bi-droplet-fill"></i>
                    <span>Calidad</span>
                </a>
                <!-- Link bound to Reportes view -->
                <a href="/reportar" class="nav-item">
                    <!-- Siren Dome Icon -->
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4a5 5 0 0 0-5 5v3H5v4h14v-4h-2V9a5 5 0 0 0-5-5zm-3 8V9a3 3 0 0 1 6 0v3H9zm-2 6h10v2H7v-2zm5-16h-4v2h4V2z"/>
                    </svg>
                    <span>Reportes</span>
                </a>
                <a href="/alertas" class="nav-item">
                    <i class="bi bi-bell-fill"></i>
                    <span>Alertas</span>
                </a>
                <a href="/estandares" class="nav-item">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Informacion</span>
                </a>
            </nav>

        @if(session()->has('usuario_nombre'))
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="color: white; font-weight: 600; font-size: 0.95rem;">
                    <i class="bi bi-person-circle"></i> {{ ucfirst(session('usuario_nombre')) }}
                </span>
                <a href="/logout" class="btn-register" style="text-decoration: none; background: rgba(231, 76, 60, 0.8); border-color: rgba(231, 76, 60, 0.4);">
                    Salir <i class="bi bi-box-arrow-right ms-1"></i>
                </a>
            </div>
        @else
            <a href="/login" class="btn-register" style="text-decoration: none;">
                <i class="bi bi-person-fill"></i>
                Registrate
            </a>
        @endif
        </header>

        <!-- Main Dashboard Layout -->
        <main>
            <!-- Hero section -->
            <section class="hero-section">
                <h1 class="hero-title">Tu tranquilidad,<br>nuestra prioridad</h1>
                <p class="hero-subtitle">
                    Hidrovida te permite monitorear la calidad del agua en tiempo real.
                    Recibe alertas instantaneas de cortes reporta incidencias facilmente
                    y consulta las normativas vigentes para asegurar el bienestar de tu familia
                </p>
                <a href="/calidad" class="btn-primary-custom">
                    Consultar calidad del agua <i class="bi bi-arrow-right"></i>
                </a>
            </section>

            <!-- Gauge section -->
            <section class="gauge-section">
                <h2 class="gauge-title">Panel de resumen de estado</h2>
                <div class="gauge">
                    <div class="gauge-inner">
                        <i class="bi bi-shield-check gauge-icon"></i>
                        <div class="gauge-text">ESTADO GENERAL:</div>
                        <div class="gauge-status">SEGURO</div>
                    </div>
                </div>
            </section>

            <!-- Info Cards section -->
            <section class="cards-container">
                <div class="cards-grid">
                    
                    <!-- Card 1 -->
                    <div class="info-card">
                        <div class="icon-wrapper">
                            <!-- Custom SVG for person with flask -->
                            <svg width="70" height="70" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                <path d="M20 7v9c0 1.1-.9 2-2 2s-2-.9-2-2V7h-1V5h6v2h-1zm-1.5 9c.28 0 .5-.22.5-.5V10h-2v5.5c0 .28.22.5.5.5zM18 11h1v1h-1zM18 13h1v1h-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Tu agua hoy:</h3>
                            <div class="highlight">PH 7.2 | optimo</div>
                            <p class="muted">Dentro del rango adecuado</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="info-card">
                        <div class="icon-wrapper" style="font-size: 4rem; padding-left: 0.5rem; margin-right: 0.5rem;">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h3>Ultima medicion</h3>
                            <div style="font-weight: 800; font-size: 1.1rem; color: var(--text-dark); margin-bottom: 0.2rem;">Hace 14 minutos</div>
                            <p class="muted">Actualizacion en tiempo real</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="action-card">
                        <div class="action-card-left">
                            <div class="icon-wrapper" style="margin-left: 0.5rem; margin-right: 0.5rem;">
                                <!-- Siren/Alarm icon -->
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4a5 5 0 0 0-5 5v3H5v4h14v-4h-2V9a5 5 0 0 0-5-5zm-3 8V9a3 3 0 0 1 6 0v3H9zm-2 6h10v2H7v-2zm5-16h-4v2h4V2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3>¿Ves algun problema?</h3>
                                <p style="font-weight: 600; color: var(--text-dark); margin:0;">Reporta incidencias y ayuda a tu comunidad</p>
                            </div>
                        </div>
                        <a href="/reportar" class="btn-teal">
                            Reportar incidencia <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Bottom Banner -->
                <div class="bottom-banner">
                    <div class="banner-text">
                        <i class="bi bi-shield-check"></i>
                        <span>Cumplimos con las normativas de calidad establecidas por las Autoridades</span>
                    </div>
                    <a href="/estandares" class="banner-link">
                        Ver normativas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </section>
        </main>

        <!-- Existing Vue Components Layout (Preserved for functionality) -->
        <div class="vue-components-wrapper">
            <pagos @buscar='buscar("buscar_pagos","obtenerPagos")' :forms="forms" ref="pagos" v-show="forms.pagos.mostrar"></pagos>
            <buscar_pagos @modificar='modificar("pagos","modificarPago", $event)' :forms="forms" ref="buscar_pagos" v-show="forms.buscar_pagos.mostrar"></buscar_pagos>

            <reportes @buscar='buscar("buscar_reportes","obtenerReportes")' :forms="forms" ref="reportes" v-show="forms.reportes.mostrar"></reportes>
            <buscar_reportes @modificar='modificar("reportes","modificarReporte", $event)' :forms="forms" ref="buscar_reportes" v-show="forms.buscar_reportes.mostrar"></buscar_reportes>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>