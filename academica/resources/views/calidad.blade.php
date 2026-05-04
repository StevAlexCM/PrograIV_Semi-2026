<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calidad del agua - HidroVida</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-dark: #1b3650;
            --text-dark: #163f5c;
            --card-bg: #bcd0de;
            --accent-teal: #2cc0b3;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #ffffff; color: var(--text-dark); -webkit-font-smoothing: antialiased; }
        
        /* Header Layout */
        .header {
            background-color: var(--primary-dark);
            color: white;
            padding: 1rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header-logo {
            color: white;
            font-size: 1.8rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .header-logo:hover {
            transform: scale(1.1);
            color: #e0f2fe;
        }
        .header-title {
            font-size: 1.1rem;
            font-weight: 700;
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

        /* Main Content */
        .main-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.5rem;
        }

        /* Top PH Card */
        .ph-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2.5rem 4rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }
        .ph-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .ph-value {
            font-size: 5rem;
            font-weight: 800;
            color: var(--primary-dark);
            line-height: 1;
            margin-bottom: 1rem;
        }
        .ph-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background-color: rgba(255,255,255,0.4);
            padding: 0.4rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            color: var(--text-dark);
            border: 1px solid rgba(255,255,255,0.5);
            font-size: 0.95rem;
        }
        .ph-status i {
            color: var(--accent-teal);
            font-size: 1.2rem;
        }

        /* Nivel de Tanque */
        .tanque-section {
            width: 100%;
        }
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        .section-header i {
            font-size: 1.4rem;
        }
        .progress-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .progress-bar-container {
            flex: 1;
            height: 20px;
            background-color: white;
            border: 2px solid var(--primary-dark);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            background-color: var(--primary-dark);
            width: 75%; /* Hardcoded 75% as per design */
            border-radius: 8px 0 0 8px;
        }
        .progress-text {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--text-dark);
            align-self: flex-start;
            margin-top: -3px;
        }
        .progress-labels-inner {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Ultima actualizacion */
        .update-section {
            width: 100%;
        }
        .update-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .update-icon {
            font-size: 2.2rem;
            color: var(--primary-dark);
        }
        .update-text h4 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }
        .update-text p {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-dark);
            opacity: 0.8;
        }

        /* Bottom Banner */
        .bottom-banner {
            width: 100%;
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .banner-icon {
            font-size: 2.8rem;
            color: var(--accent-teal);
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banner-icon i {
            margin-top: 2px;
        }
        .banner-text h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }
        .banner-text p {
            font-size: 0.95rem;
            font-weight: 500;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .header { padding: 1rem; }
            .bottom-banner {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="/" class="header-logo" title="Volver al inicio">
            <i class="bi bi-house-door-fill"></i>
        </a>
        <div class="header-title">Calidad del agua</div>
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

    <!-- Main Content -->
    <main class="main-container">
        
        <!-- PH Card -->
        <div class="ph-card">
            <div class="ph-title">PH ACTUAL</div>
            <div class="ph-value">7.2</div>
            <div class="ph-status">
                <i class="bi bi-check-circle"></i> Normal
            </div>
        </div>

        <!-- Nivel de Tanque -->
        <div class="tanque-section">
            <div class="section-header">
                <i class="bi bi-droplet-fill"></i> Nivel de tanque
            </div>
            <div class="progress-wrapper">
                <div style="flex: 1;">
                    <div class="progress-bar-container">
                        <div class="progress-fill"></div>
                    </div>
                    <div class="progress-labels-inner">
                        <span>0%</span>
                        <span>50%</span>
                        <span>100%</span>
                    </div>
                </div>
                <div class="progress-text">75%</div>
            </div>
        </div>

        <!-- Ultima actualizacion -->
        <div class="update-section">
            <div class="update-info">
                <div class="update-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
                <div class="update-text">
                    <h4>Ultima actualizacion</h4>
                    <p>hace 5 minutos</p>
                </div>
            </div>
        </div>

        <!-- Bottom Banner -->
        <div class="bottom-banner">
            <div class="banner-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="banner-text">
                <h3>El agua es apta para el consumo</h3>
                <p>Todos los parametros dentro del rango del MINSAL</p>
            </div>
        </div>

    </main>
</body>
</html>
