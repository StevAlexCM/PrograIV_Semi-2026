<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estandares permitidos - HidroVida</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-dark: #1b3650;
            --text-dark: #1b3650;
            --card-bg: #c0d6e4;
            --accent-teal: #2cc0b3;
            --green-color: #2ebc2e;
            --yellow-color: #f1c40f;
            --red-color: #e74c3c;
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
            background: rgba(255, 255, 255, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
        }
        .header-logo:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }
        .header-title {
            font-size: 1.2rem;
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
            max-width: 950px;
            margin: 3rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Info Card */
        .info-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 2.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-4px);
        }
        .card-icon {
            flex-shrink: 0;
            color: var(--primary-dark);
        }
        .card-content {
            flex-grow: 1;
        }
        .card-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.8rem;
        }
        .card-text {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        /* Standard Legends */
        .standards-row {
            display: flex;
            align-items: center;
            gap: 3rem;
            font-weight: 700;
            font-size: 0.95rem;
        }
        .standard-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .standard-minsal { color: var(--green-color); }
        .standard-oms { color: var(--text-dark); }
        .standard-icon { font-size: 1.2rem; }

        /* Color Legend Row */
        .color-legend-row {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 1rem;
        }
        .color-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .color-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .circle-green { background-color: var(--green-color); }
        .circle-yellow { background-color: var(--yellow-color); }
        .circle-red { background-color: var(--red-color); }
        
        .text-green { color: var(--green-color); }
        .text-yellow { color: #d4a700; /* slightly darker yellow for text readability */ }
        .text-red { color: var(--red-color); }

        /* Bottom Banner */
        .bottom-banner {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            justify-content: center;
        }
        .banner-icon {
            font-size: 1.5rem;
            color: var(--accent-teal);
        }
        .banner-text {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .header { padding: 1rem; flex-direction: column; gap: 1rem; }
            .info-card { flex-direction: column; text-align: center; padding: 2rem 1.5rem; gap: 1.5rem; }
            .standards-row, .color-legend-row { flex-direction: column; gap: 1rem; align-items: center; }
            .bottom-banner { padding: 1rem; text-align: center; flex-direction: column; gap: 0.5rem; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="/" class="header-logo" title="Volver al inicio">
            <i class="bi bi-house-door-fill"></i>
        </a>
        <div class="header-title">Estandares permitidos - MINSAL/OMS</div>
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
        
        <!-- Card 1: pH -->
        <div class="info-card">
            <div class="card-icon">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-5.5c-.5 1.5-2 3.9-4 5.5S5 13 5 15a7 7 0 0 0 7 7z"></path>
                    <path d="M12 18a3 3 0 0 0 3-3c0-1.5-1.5-3-3-4.5-1.5 1.5-3 3-3 4.5a3 3 0 0 0 3 3z" fill="rgba(255,255,255,0.2)"></path>
                </svg>
            </div>
            <div class="card-content">
                <h3 class="card-title">¿Qué es el pH del agua?</h3>
                <p class="card-text">Mide si el agua es ácida o básica. Un pH entre 6.5 y 8.5 es seguro para tomar.</p>
                <div class="standards-row">
                    <div class="standard-item standard-minsal">
                        <i class="bi bi-check-circle standard-icon"></i>
                        <span>MINSAL: 6.5 - 8.5</span>
                    </div>
                    <div class="standard-item standard-oms">
                        <i class="bi bi-globe standard-icon"></i>
                        <span>OMS: 6.5 - 8.5</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Cloro -->
        <div class="info-card">
            <div class="card-icon">
                <!-- Erlenmeyer flask SVG -->
                <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.38 18.5L14 9V5h1V3H9v2h1v4L4.62 18.5A2.5 2.5 0 0 0 6.88 22h10.24a2.5 2.5 0 0 0 2.26-3.5z"></path>
                </svg>
            </div>
            <div class="card-content">
                <h3 class="card-title">¿Qué es el cloro residual?</h3>
                <p class="card-text">El cloro mata bacterias en el agua. Debe estar entre 0.3 y 1.5 mg/L para ser seguro</p>
                <div class="standards-row">
                    <div class="standard-item standard-minsal">
                        <i class="bi bi-check-circle standard-icon"></i>
                        <span>MINSAL: 0.3 - 1.5 mg/L</span>
                    </div>
                    <div class="standard-item standard-oms">
                        <i class="bi bi-globe standard-icon"></i>
                        <span>OMS: 0.2 - 1.0 mg/L</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Indicador de color -->
        <div class="info-card">
            <div class="card-icon">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-5.5c-.5 1.5-2 3.9-4 5.5S5 13 5 15a7 7 0 0 0 7 7z"></path>
                    <path d="M12 18a3 3 0 0 0 3-3c0-1.5-1.5-3-3-4.5-1.5 1.5-3 3-3 4.5a3 3 0 0 0 3 3z" fill="rgba(255,255,255,0.2)"></path>
                </svg>
            </div>
            <div class="card-content">
                <h3 class="card-title" style="margin-bottom: 0;">¿Qué significa el color del indicador?</h3>
                <div class="color-legend-row">
                    <div class="color-item">
                        <div class="color-circle circle-green"></div>
                        <span class="text-green">Verde = Seguro</span>
                    </div>
                    <div class="color-item">
                        <div class="color-circle circle-yellow"></div>
                        <span class="text-yellow">Amarillo = Revisar</span>
                    </div>
                    <div class="color-item">
                        <div class="color-circle circle-red"></div>
                        <span class="text-red">Rojo = No tomar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Banner -->
        <div class="bottom-banner">
            <i class="bi bi-shield-check banner-icon"></i>
            <span class="banner-text">Estos valores estan basados en las recomendaciones del Ministerio de Salud(MINSAL) y la Organizacion Mundial de la Salud(OMS).</span>
        </div>

    </main>
</body>
</html>
