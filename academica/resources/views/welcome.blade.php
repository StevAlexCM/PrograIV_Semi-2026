@extends('layouts.public')

@section('title', 'HidroVida - Panel Principal')

@section('styles')
<style>
        .hero-section {
            padding: 6rem 0 4rem;
            text-align: center;
        }
        .hero-title {
            color: #1a5c8b;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .hero-subtitle {
            color: #299bc4;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
            line-height: 1.5;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-primary-custom {
            background-color: #255f84;
            color: white;
            padding: 0.8rem 2.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover { background-color: #1b4b6b; color: white; }

        .alert-banner {
            border: 2px solid var(--alert-red);
            background-color: #ffeeee;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }
        .alert-banner-left { display: flex; align-items: center; gap: 1.5rem; }
        .alert-icon-triangle { color: var(--alert-red); font-size: 3rem; line-height: 1; }
        .alert-banner h3 { color: var(--alert-red); font-weight: 800; margin: 0; font-size: 1.3rem; }
        .alert-banner p { margin: 0; font-weight: 500; color: #333; }
        .btn-red {
            background-color: var(--alert-red);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-red:hover { background-color: #e0484d; color: white; }

        .panel-container {
            background-color: #d8e2eb;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }
        .panel-title {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 2rem;
            font-size: 1.4rem;
        }

        .gauge-section-new {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .gauge-container { text-align: center; }
        .gauge-box {
            position: relative;
            width: 300px;
            height: 150px;
            background: conic-gradient(from 270deg at 50% 100%, 
                var(--gauge-green) 0deg, var(--gauge-green) 90deg, 
                var(--gauge-yellow) 90deg, var(--gauge-yellow) 135deg, 
                var(--gauge-red) 135deg, var(--gauge-red) 180deg, 
                transparent 180deg);
            border-radius: 150px 150px 0 0;
        }
        .gauge-inner-box {
            position: absolute;
            width: 240px;
            height: 120px;
            background-color: #d8e2eb;
            border-radius: 120px 120px 0 0;
            bottom: 0;
            left: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 1rem;
        }
        .gauge-inner-box i { color: var(--accent-teal); font-size: 3rem; margin-bottom: -5px; }
        .gauge-text { font-size: 0.9rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }
        .gauge-status { color: var(--accent-teal); font-size: 1.2rem; font-weight: 800; }

        /* Status Items */
        .status-items { display: flex; flex-direction: column; gap: 2rem; }
        .status-item { display: flex; align-items: center; gap: 1.5rem; }
        .status-icon { font-size: 3rem; color: #4b6b8a; }
        .status-item h4 { color: var(--primary-dark); font-weight: 800; font-size: 1.2rem; margin: 0 0 0.2rem 0; }
        .status-item .highlight-text { color: var(--primary-dark); font-weight: 700; font-size: 1rem; }
        .status-item .highlight-text span { color: var(--primary-light); }
        .status-item p { margin: 0; font-size: 0.8rem; color: #5a7b9c; }

        /* Action Banner */
        .action-banner {
            background-color: #d8e2eb;
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .action-banner-left { display: flex; align-items: center; gap: 1.5rem; }
        .action-banner-left i { font-size: 3.5rem; color: #4b6b8a; }
        .action-banner h3 { color: var(--primary-dark); font-weight: 800; margin: 0 0 0.5rem 0; }
        .action-banner p { color: var(--primary-dark); font-weight: 600; margin: 0; }
        
        .btn-teal {
            background-color: var(--accent-teal);
            color: white;
            padding: 0.8rem 1.8rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-teal:hover { background-color: #24a095; color: white; }

        /* Tips Section */
        .tips-section h3 { color: var(--primary-dark); font-weight: 800; margin-bottom: 1.5rem; }
        .tip-card {
            background: #fae8e8;
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            position: relative;
        }
        .tip-card.bg-blue { background: #eef2ff; }
        .tip-card.bg-green { background: #f0fdf4; }
        .tip-card-img-placeholder {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: rgba(0,0,0,0.2);
            background: rgba(255,255,255,0.5);
            border-radius: 8px;
        }
        .tip-card img { width: 80px; height: auto; object-fit: contain; }
        .tip-card h5 { color: var(--primary-dark); font-weight: 800; font-size: 1.1rem; margin: 0 0 0.5rem 0; }
        .tip-card p { margin: 0; font-size: 0.85rem; color: #4b6b8a; font-weight: 500; }

        /* Compliance Banner */
        .compliance-banner {
            background-color: #d8e2eb;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 3rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .compliance-banner-left { display: flex; align-items: center; gap: 1rem; color: var(--primary-dark); font-weight: 600; }
        .compliance-banner-left i { font-size: 1.5rem; color: var(--accent-teal); }
        .compliance-link {
            color: var(--primary-dark);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.4);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .compliance-link:hover { background: rgba(255,255,255,0.7); }

        /* Footer */
        .custom-footer {
            background-color: #729fba;
            color: white;
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        .footer-logo {
            display: flex;
            flex-direction: column;
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
            .hero-section { text-align: center; }
            .hero-section img { margin-top: 2rem; max-width: 80%; }
            .alert-banner { flex-direction: column; text-align: center; gap: 1.5rem; }
            .alert-banner-left { flex-direction: column; gap: 0.5rem; }
            .gauge-section-new { flex-direction: column; }
            .action-banner { flex-direction: column; text-align: center; }
            .action-banner-left { flex-direction: column; gap: 0.5rem; }
            .compliance-banner { flex-direction: column; text-align: center; }
            .tip-card { flex-direction: column; text-align: center; }
            .custom-footer .row > div { margin-bottom: 2rem; text-align: center; }
            .footer-logo { align-items: center; }
        }
</style>
@endsection

@section('content')
@php
    $ph = isset($sensor) ? $sensor->ph_level : 7.2;
    $time_ago = isset($sensor) ? $sensor->updated_at->diffForHumans() : 'Hace 14 minutos';
    
    if ($ph >= 6.5 && $ph <= 8.5) {
        $statusColor = '#2cc0b3'; // teal
        $statusText = 'SEGURO';
        $statusIcon = 'bi-shield-check';
        $optimoText = 'Óptimo';
        $optimoSubText = 'Dentro del rango adecuado';
    } elseif (($ph >= 6.0 && $ph < 6.5) || ($ph > 8.5 && $ph <= 9.0)) {
        $statusColor = '#f1c40f'; // yellow
        $statusText = 'REVISAR';
        $statusIcon = 'bi-exclamation-triangle';
        $optimoText = 'Precaución';
        $optimoSubText = 'pH ligeramente alterado';
    } else {
        $statusColor = '#e74c3c'; // red
        $statusText = 'PELIGRO';
        $statusIcon = 'bi-x-octagon';
        $optimoText = 'Peligroso';
        $optimoSubText = 'No apta para consumo';
    }
@endphp

            <section class="hero-section row align-items-center">
                <div class="col-md-6 d-flex flex-column align-items-center text-center px-4">
                    <h1 class="hero-title">Tu tranquilidad,<br>nuestra prioridad</h1>
                    <p class="hero-subtitle">
                        Hidrovida te permite monitorear la calidad del<br>agua en tiempo real.<br>
                        Recibe alertas instantaneas de cortes y reporta<br>
                        incidencias facilmente para asegurar el<br>
                        bienestar de tu familia
                    </p>
                    <a href="/calidad" class="btn-primary-custom mt-2">
                        Consultar calidad del agua &rarr;
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    
                    <img src="{{ asset('img/tanque.png') }}" alt="Water Tower" class="img-fluid" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <i class="bi bi-building" style="font-size: 10rem; color: #2099c2; display: none;"></i>
                </div>
            </section>

            
            @if(isset($alerta_roja))
            <div class="alert-banner">
                <div class="alert-banner-left">
                    <i class="bi bi-exclamation-triangle-fill alert-icon-triangle"></i>
                    <div>
                        <h3>Alerta activa</h3>
                        <p>{{ $alerta_roja->titulo }}<br>{{ $alerta_roja->fecha_texto }}</p>
                    </div>
                </div>
                <a href="/alertas" class="btn-red">Ver todas las alertas &rarr;</a>
            </div>
            @endif

            
            <div class="panel-container">
                <h2 class="panel-title">Panel de resumen de estado</h2>
                <div class="gauge-section-new">
                    
                    <div class="gauge-container">
                        <div class="gauge-box" style="border-color: {{ $statusColor }}30;">
                            <div class="gauge-inner-box">
                                <i class="bi {{ $statusIcon }}" style="color: {{ $statusColor }};"></i>
                                <div class="gauge-text">ESTADO GENERAL:</div>
                                <div class="gauge-status" style="color: {{ $statusColor }};">{{ $statusText }}</div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="status-items">
                        <div class="status-item">
                            <i class="bi bi-person-badge status-icon"></i>
                            <div>
                                <h4>Tu agua hoy:</h4>
                                <div class="highlight-text">PH {{ number_format($ph, 1) }} | <span style="color: {{ $statusColor }};">{{ $optimoText }}</span></div>
                                <p>{{ $optimoSubText }}</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <i class="bi bi-clock status-icon"></i>
                            <div>
                                <h4>Ultima medición</h4>
                                <div class="highlight-text" style="font-size: 1.1rem; color: #1b3650;">{{ str_replace('hace ', 'Hace ', $time_ago) }}</div>
                                <p>Actualización en tiempo real</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="action-banner">
                <div class="action-banner-left">
                    <i class="bi bi-megaphone"></i>
                    <div>
                        <h3>¿Ves algun problema?</h3>
                        <p>Reporta incidencias y ayuda a tu comunidad</p>
                    </div>
                </div>
                <a href="/reportar" class="btn-teal">Reportar incidencia &rarr;</a>
            </div>

            
            <div class="tips-section mb-5">
                <h3 style="color: #1a5c8b; font-weight: 800; margin-bottom: 2rem;">Consejos para el cuidado del agua</h3>
                <div class="d-flex align-items-center justify-content-between gap-3">
                    
                    
                    <div class="row w-100 mx-0">
                        <div class="col-md-4 px-2">
                            <img src="{{ asset('img/ducha.jpg') }}" class="img-fluid w-100" style="border-radius: 4px;" alt="Ducha">
                        </div>
                        <div class="col-md-4 px-2">
                            <img src="{{ asset('img/fugas.jpg') }}" class="img-fluid w-100" style="border-radius: 4px;" alt="Fuga">
                        </div>
                        <div class="col-md-4 px-2">
                            <img src="{{ asset('img/lavadora.jpg') }}" class="img-fluid w-100" style="border-radius: 4px;" alt="Lavadora">
                        </div>
                    </div>

                    
                </div>
            </div>

            
            <div class="compliance-banner">
                <div class="compliance-banner-left">
                    <i class="bi bi-shield-check"></i>
                    <span>Cumplimos con las normativas de calidad establecidas por las Autoridades</span>
                </div>
                <a href="/estandares" class="compliance-link">Ver normativas de OMS y MINSAL &rarr;</a>
            </div>
            
            
@endsection
