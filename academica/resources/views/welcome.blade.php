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

        /* User Dashboard Specific Layouts */
        .dot-flashing {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #2cc0b3;
            animation: dot-flashing-anim 1s infinite alternate;
        }
        @keyframes dot-flashing-anim {
            0% { opacity: 0.3; }
            100% { opacity: 1; }
        }

        .extra-small { font-size: 0.8rem; }
        .extra-extra-small { font-size: 0.72rem; }

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
    $time_ago = isset($sensor) ? $sensor->updated_at->diffForHumans() : 'Hace unos minutos';
    
    if ($ph >= 6.5 && $ph <= 8.5) {
        $statusColor = '#2cc0b3'; // teal/green
        $statusText = 'SEGURO';
        $statusIcon = 'bi-shield-check';
        $optimoText = 'Óptimo';
        $optimoSubText = 'Tu agua es apta para el consumo';
    } elseif (($ph >= 6.0 && $ph < 6.5) || ($ph > 8.5 && $ph <= 9.0)) {
        $statusColor = '#f1c40f'; // yellow
        $statusText = 'PRECAUCIÓN';
        $statusIcon = 'bi-exclamation-triangle';
        $optimoText = 'Revisar';
        $optimoSubText = 'Precaución - pH ligeramente fuera de rango';
    } else {
        $statusColor = '#e74c3c'; // red
        $statusText = 'RIESGO';
        $statusIcon = 'bi-x-octagon';
        $optimoText = 'Peligro';
        $optimoSubText = 'No apta para el consumo humano';
    }
@endphp

@if(session()->has('usuario_id'))
   
    @if(isset($alerta_prioritaria) && in_array($alerta_prioritaria->tipo, ['red', 'yellow', 'blue']))
        @php
            $bg_color = '#fffdeb';
            $border_color = '#ffc107';
            $icon_bg = '#fff5cc';
            $icon_class = 'bi-exclamation-circle-fill text-warning';
            
            if ($alerta_prioritaria->tipo === 'red') {
                $bg_color = '#fff5f5';
                $border_color = '#ff5a5f';
                $icon_bg = '#ffe3e3';
                $icon_class = 'bi-exclamation-triangle-fill text-danger';
            } elseif ($alerta_prioritaria->tipo === 'blue') {
                $bg_color = '#eef6fc';
                $border_color = '#299bc4';
                $icon_bg = '#cce3ff';
                $icon_class = 'bi-info-circle-fill text-primary';
            }
        @endphp
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: {{ $bg_color }}; border-left: 5px solid {{ $border_color }} !important;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2.5 d-flex align-items-center justify-content-center" style="background-color: {{ $icon_bg }}; width: 48px; height: 48px;">
                        <i class="bi {{ $icon_class }} fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-dark" style="font-size: 1.15rem;">{{ $alerta_prioritaria->titulo }}</h5>
                        <p class="text-secondary extra-small mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $alerta_prioritaria->zona }} · <i class="bi bi-clock me-1"></i>{{ $alerta_prioritaria->fecha_texto }}</p>
                        <p class="mb-0 text-muted small"><strong class="text-dark">Motivo:</strong> {{ $alerta_prioritaria->motivo }}</p>
                    </div>
                </div>
                <a href="/alertas" class="btn btn-sm rounded-pill px-4 fw-bold" style="background-color: {{ $alerta_prioritaria->tipo === 'red' ? '#ff5a5f' : ($alerta_prioritaria->tipo === 'blue' ? '#299bc4' : '#ffc107') }}; color: {{ $alerta_prioritaria->tipo === 'yellow' ? 'black' : 'white' }}; border: none;">Ver detalles</a>
            </div>
        </div>
    @endif

    <!-- 2. Water Quality Circular Gauge (Estado general del agua) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-center">
        <h5 class="fw-bold text-dark text-start mb-4"><i class="bi bi-activity text-primary me-2"></i>Estado general del agua</h5>
        <div class="d-flex flex-column align-items-center">
            <div class="gauge-container">
                <div class="gauge-box" style="border-color: {{ $statusColor }}30;">
                    <div class="gauge-inner-box">
                        <i class="bi {{ $statusIcon }}" style="color: {{ $statusColor }};"></i>
                        <div class="gauge-text">ESTADO GENERAL:</div>
                        <div class="gauge-status" style="color: {{ $statusColor }};">{{ $statusText }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Dynamic Sensor Info cards (3 cards grid) -->
    <div class="row g-4 mb-4">
        <!-- Card 1: pH -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3.5">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="background-color: #eef7fc; color: #299bc4; width: 48px; height: 48px;">
                        <i class="bi bi-droplet fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted extra-small fw-semibold">pH del agua</div>
                        <div class="fs-3 fw-bold text-dark mb-1">{{ number_format($ph, 1) }}</div>
                        <span class="badge extra-small px-2.5 py-1" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }}; border: 1px solid {{ $statusColor }}50;">{{ $optimoText }}</span>
                        <div class="text-muted extra-extra-small mt-2">Rango ideal: 6.5 - 8.5</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Tank Level -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3.5">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="background-color: #f0fdf4; color: #198754; width: 48px; height: 48px;">
                        <i class="bi bi-database fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-muted extra-small fw-semibold">Nivel del tanque</div>
                        <div class="fs-3 fw-bold text-dark mb-1">{{ $sensor->water_level }}%</div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $sensor->water_level }}%;" aria-valuenow="{{ $sensor->water_level }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-muted extra-extra-small mt-2">Capacidad del tanque</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Last Measurement -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3.5">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="background-color: #fffbeb; color: #d97706; width: 48px; height: 48px;">
                        <i class="bi bi-clock fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted extra-small fw-semibold">Última medición</div>
                        <div class="fs-5 fw-bold text-dark mb-1" style="line-height: 1.2;">{{ str_replace('hace ', 'Hace ', $time_ago) }}</div>
                        <div class="text-muted extra-extra-small mb-2">{{ $sensor->updated_at ? \Carbon\Carbon::parse($sensor->updated_at)->isoFormat('D [de] MMMM, hh:mm A') : '' }}</div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle extra-small px-2 py-1 d-inline-flex align-items-center gap-1.5">
                            <span class="dot-flashing"></span> En tiempo real
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Water Bill Delivery Section (Mi último recibo) -->
    @if(isset($ultimo_recibo))
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt text-warning me-2"></i>Mi Último Recibo de Agua</h5>
                <span class="badge rounded-pill px-3 py-1.5 {{ $ultimo_recibo->estado_pago === 'Pagado' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}">
                    {{ $ultimo_recibo->estado_pago || 'Pendiente' }}
                </span>
            </div>
            
            <div class="row align-items-center g-3">
                <div class="col-md-7">
                    <p class="text-muted small mb-2">Se ha emitido tu recibo de consumo de agua potable correspondiente al periodo **{{ $ultimo_recibo->mes_facturado }}**.</p>
                    <div class="row g-2 text-dark extra-small">
                        <div class="col-6"><strong>Medición Anterior:</strong> {{ (float)$ultimo_recibo->lectura_anterior }} m³</div>
                        <div class="col-6"><strong>Medición Actual:</strong> {{ (float)$ultimo_recibo->lectura_actual }} m³</div>
                        <div class="col-6"><strong>Consumo Neto:</strong> {{ (float)$ultimo_recibo->consumo }} m³</div>
                        <div class="col-6"><strong>Total Facturado:</strong> <span class="fw-bold text-primary">${{ number_format($ultimo_recibo->total_pagar, 2) }}</span></div>
                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2" onclick='imprimirTicket({{ json_encode($ultimo_recibo) }})'>
                        <i class="bi bi-printer"></i> Imprimir Recibo
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- 5. Quick Actions (Acciones rápidas) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold text-dark mb-3">Acciones rápidas</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="/calidad" class="btn btn-outline-primary w-100 rounded-3 py-3 fw-bold d-flex justify-content-between align-items-center px-3.5" style="text-decoration: none;">
                    <span>Consultar calidad completa</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/reportar" class="btn btn-outline-success w-100 rounded-3 py-3 fw-bold d-flex justify-content-between align-items-center px-3.5" style="text-decoration: none;">
                    <span>Reportar problema / falla</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="col-md-4">
                </a>
            </div>
        </div>
    </div>

    <!-- 6. Banner de Cumplimiento -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #f0fdf4; border: 1px solid #d1fae5;">
        <div class="card-body p-3.5 d-flex align-items-center gap-3">
            <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-shield-fill-check fs-4"></i>
            </div>
            <div class="text-success small fw-semibold flex-grow-1">
                Tu agua cumple con los estándares de calidad del MINSAL y la OMS. Seguimos monitoreando para garantizar tu bienestar.
            </div>
        </div>
    </div>

    <!-- 7. Recent Notifications feed -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">Notificaciones recientes</h5>
            <a href="/alertas" class="text-decoration-none small fw-semibold text-primary">Ver todas</a>
        </div>
        <div class="list-group list-group-flush">
            @foreach($alertas_recientes as $al)
                @php
                    $circleColorClass = 'bg-warning bg-opacity-10 text-warning';
                    $bellIconClass = 'bi-bell';
                    if ($al->tipo === 'red') {
                        $circleColorClass = 'bg-danger bg-opacity-10 text-danger';
                        $bellIconClass = 'bi-bell-fill';
                    } elseif ($al->tipo === 'blue') {
                        $circleColorClass = 'bg-primary bg-opacity-10 text-primary';
                        $bellIconClass = 'bi-info-circle';
                    }
                @endphp
                <a href="/alertas" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3 border-bottom border-light px-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center {{ $circleColorClass }}" style="width: 38px; height: 38px;">
                            <i class="bi {{ $bellIconClass }}"></i>
                        </div>
                        <div>
                            <h6 class="mb-0.5 fw-bold text-dark small">{{ $al->titulo }}</h6>
                            <p class="mb-0 text-muted extra-small">{{ $al->zona }} · {{ $al->fecha_texto }}</p>
                        </div>
                    </div>
                    <small class="text-muted extra-extra-small">{{ $al->created_at ? $al->created_at->diffForHumans() : 'Recientemente' }}</small>
                </a>
            @endforeach
            <!-- Sensor Simulation notification template -->
            <div class="list-group-item d-flex align-items-center justify-content-between py-3 border-0 px-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-droplet"></i>
                    </div>
                    <div>
                        <h6 class="mb-0.5 fw-bold text-dark small">Nueva medición registrada</h6>
                        <p class="mb-0 text-muted extra-small">pH: {{ number_format($ph, 1) }} - Estado: {{ $optimoText }}</p>
                    </div>
                </div>
                <small class="text-muted extra-extra-small">{{ str_replace('hace ', 'Hace ', $time_ago) }}</small>
            </div>
        </div>
    </div>

@else
    <!-- ========================================== -->
    <!-- GUEST WELCOME LANDING VIEW                 -->
    <!-- ========================================== -->
    
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

            @if(isset($alerta_prioritaria) && $alerta_prioritaria->tipo === 'red')
            <div class="alert-banner">
                <div class="alert-banner-left">
                    <i class="bi bi-exclamation-triangle-fill alert-icon-triangle"></i>
                    <div>
                        <h3>Alerta activa</h3>
                        <p>{{ $alerta_prioritaria->titulo }}<br>{{ $alerta_prioritaria->fecha_texto }}</p>
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
@endif

@endsection

@section('scripts')
<script>
// Receipt Printing Script
function imprimirTicket(pago) {
    const windowUrl = 'about:blank';
    const uniqueName = new Date().getTime();
    const windowName = 'Print' + uniqueName;
    const PrintWindow = window.open(windowUrl, windowName, 'left=500,top=100,width=400,height=600');
    const fechaStr = new Date(pago.fecha_pago || pago.created_at).toLocaleString('es-ES', {
        day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
    const totalStr = parseFloat(pago.total_pagar).toFixed(2);
    const consumoStr = parseFloat(pago.consumo).toFixed(2);
    const anteriorStr = parseFloat(pago.lectura_anterior).toFixed(2);
    const actualStr = parseFloat(pago.lectura_actual).toFixed(2);
    const costoConsumoStr = (parseFloat(pago.consumo) * 1.50).toFixed(2);
    
    PrintWindow.document.write(`
      <html>
        <head>
          <title>Imprimir Recibo - HidroVida</title>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
          <style>
            body { font-family: monospace; padding: 20px; color: #000; }
            .border-dashed { border-top: 2px dashed #000; }
            .extra-small { font-size: 0.8rem; }
            .extra-extra-small { font-size: 0.7rem; }
            @media print {
              body { padding: 0; }
              .no-print { display: none; }
            }
          </style>
        </head>
        <body onload="window.print();window.close()">
          <div style="max-width: 300px; margin: 0 auto; text-align: center;">
            <h5 class="fw-extrabold text-uppercase text-primary mb-1">HIDROVIDA.</h5>
            <p class="text-muted extra-small mb-0">Sistema de Control de Agua Potable</p>
            <p class="text-muted extra-small">El Salvador</p>
            <div class="border-top border-dashed my-2"></div>
            <h6 class="fw-bold text-dark mb-0">RECIBO DE CONSUMO MENSUAL</h6>
            <small class="text-muted">Factura No: HVR-${pago.id_pago}</small>
            
            <div class="extra-small text-start text-dark mt-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">No. Cuenta / ID:</span>
                <span class="fw-bold">#${pago.id_usuario}</span>
              </div>
              <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Periodo Facturado:</span>
                <span class="fw-bold">${pago.mes_facturado}</span>
              </div>
              <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Fecha de Emisión:</span>
                <span class="fw-bold">${fechaStr}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-muted">Estado:</span>
                <span class="badge ${pago.estado_pago === 'Pagado' ? 'bg-success text-white' : 'bg-warning text-dark'}">
                  ${pago.estado_pago || 'Pendiente'}
                </span>
              </div>
            </div>
            
            <div class="border-top border-dashed my-3"></div>
            
            <h6 class="fw-bold text-dark text-start mb-2 extra-small">Lecturas Registradas</h6>
            <div class="extra-small text-muted d-flex justify-content-between mb-1">
              <span>Lectura Anterior:</span>
              <span class="text-dark">${anteriorStr} m³</span>
            </div>
            <div class="extra-small text-muted d-flex justify-content-between mb-1">
              <span>Lectura Actual:</span>
              <span class="text-dark">${actualStr} m³</span>
            </div>
            <div class="extra-small text-muted d-flex justify-content-between mb-2">
              <span>Consumo del Mes:</span>
              <span class="fw-bold text-dark">${consumoStr} m³</span>
            </div>
            
            <div class="border-top border-dashed my-3"></div>
            
            <h6 class="fw-bold text-dark text-start mb-2 extra-small">Detalle de Cobro</h6>
            <div class="extra-small text-muted d-flex justify-content-between mb-1">
              <span>Cuota Fija Base:</span>
              <span class="text-dark">$4.50</span>
            </div>
            <div class="extra-small text-muted d-flex justify-content-between mb-2">
              <span>Consumo (${consumoStr} m³ x $1.50):</span>
              <span class="text-dark">$${costoConsumoStr}</span>
            </div>
            
            <div class="border-top border-dashed my-2"></div>
            
            <div class="d-flex justify-content-between fw-bold text-dark fs-5 py-1">
              <span>Total a Pagar:</span>
              <span class="text-primary">$${totalStr}</span>
            </div>
            
            <div class="border-top border-dashed my-3"></div>
            
            <div class="text-center mt-3 text-muted extra-extra-small">
              <p class="mb-1">¡Gracias por hacer un uso responsable del agua!</p>
              <p class="mb-0">Para soporte o dudas contáctanos en soporte@hidrovida.com</p>
            </div>
          </div>
        </body>
      </html>
    `);
    PrintWindow.document.close();
    PrintWindow.focus();
}
</script>
@endsection
