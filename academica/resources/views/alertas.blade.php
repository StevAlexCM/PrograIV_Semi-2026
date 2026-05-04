<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avisos de corte - HidroVida</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-dark: #1b3650;
            --text-dark: #333333;
            --alert-red-bg: #ffffff;
            --alert-red-border: #ef4444;
            --alert-red-text: #ef4444;
            --alert-yellow-bg: #fffde7;
            --alert-yellow-border: #fbbf24;
            --alert-yellow-text: #1b3650;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #f8fafc; color: var(--text-dark); -webkit-font-smoothing: antialiased; }
        
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
        }

        .alert-card {
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .alert-card:hover {
            transform: translateY(-5px);
        }
        .alert-card-left {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .alert-title {
            font-size: 1.3rem;
            font-weight: 800;
        }
        .alert-details {
            font-size: 0.95rem;
            line-height: 1.6;
            font-weight: 500;
        }
        .alert-icon {
            font-size: 3.5rem;
        }

        /* Alert Variants */
        .alert-red {
            background-color: var(--alert-red-bg);
            border: 2px solid var(--alert-red-border);
            color: var(--alert-red-text);
        }
        .alert-red .alert-title, .alert-red .alert-details {
            color: var(--alert-red-text);
        }
        .alert-red .alert-icon {
            color: var(--alert-red-border);
        }

        .alert-yellow {
            background-color: var(--alert-yellow-bg);
            border: 2px solid var(--alert-yellow-border);
            color: var(--alert-yellow-text);
        }
        .alert-yellow .alert-title {
            color: var(--alert-yellow-text);
        }
        .alert-yellow .alert-details {
            color: var(--alert-yellow-text);
            opacity: 0.9;
        }
        .alert-yellow .alert-icon {
            color: var(--alert-yellow-border);
        }

        @media (max-width: 768px) {
            .header { padding: 1rem; }
            .alert-card {
                flex-direction: column-reverse;
                text-align: center;
                gap: 1.5rem;
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
        <div class="header-title">Avisos de corte de agua</div>
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
        <!-- Card 1 -->
        <div class="alert-card alert-red">
            <div class="alert-card-left">
                <div class="alert-title">Corte programado para hoy</div>
                <div class="alert-details">
                    Martes 22 de abril de 8:00 AM - 2:00PM<br>
                    Zonas afectadas: zona norte<br>
                    Motivo: fuga de agua a gran escala
                </div>
            </div>
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="alert-card alert-yellow">
            <div class="alert-card-left">
                <div class="alert-title">Corte proxima semana</div>
                <div class="alert-details">
                    Lunes 28 de abril todo el dia<br>
                    Zona afectada: Todo el canton<br>
                    Motivo: Mantenimiento de tuberia principal
                </div>
            </div>
            <div class="alert-icon">
                <i class="bi bi-bell-fill"></i>
            </div>
        </div>
    </main>
</body>
</html>
