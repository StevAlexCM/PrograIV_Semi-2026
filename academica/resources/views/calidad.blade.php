@extends('layouts.public')

@section('title', 'Información y Estándares - HidroVida')

@section('styles')
<style>
    .page-container {
        max-width: 1100px;
        margin: 3rem auto 5rem auto;
        padding: 0 1.5rem;
    }

    .main-layout {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2rem;
        align-items: stretch;
    }

    @media (max-width: 850px) {
        .main-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Sidebar Styles */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        background-color: white;
        border-radius: 16px;
        padding: 1.8rem 1.5rem;
        height: 100%;
        justify-content: space-between;
    }

    .ph-card {
        background-color: #d1e2ec;
        border-radius: 16px;
        padding: 1.5rem 1.2rem;
        text-align: center;
        color: #1b3650;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .ph-title {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
        color: #1b3650;
    }

    .ph-value {
        font-size: 4.8rem;
        font-weight: 800;
        color: #40c41d;
        line-height: 1;
        margin-bottom: 0.8rem;
    }

    .ph-status {
        background-color: rgba(64, 196, 29, 0.15);
        border: 1px solid #40c41d;
        color: #2e7d32;
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 0.95rem;
    }
    
    .ph-status svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
    }

    .sidebar-info-group {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        padding: 0.2rem 0;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 1.2rem;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-icon svg {
        width: 100%;
        height: 100%;
        fill: #1b3650;
    }

    .info-text-group {
        display: flex;
        flex-direction: column;
        color: #1b3650;
        width: 100%;
    }

    .info-label {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 0.2rem;
    }

    .info-sub {
        font-size: 0.95rem;
        color: #4a657c;
        font-weight: 500;
    }

    .progress-container {
        margin-top: 0.5rem;
        width: 100%;
    }

    .progress-bar-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.2rem;
    }

    .progress-bar-bg {
        flex-grow: 1;
        height: 14px;
        background-color: #ffffff;
        border-radius: 4px;
        border: 1px solid #1b3650;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background-color: #40c41d;
        border-radius: 2px;
    }

    .progress-value-text {
        font-size: 0.9rem;
        font-weight: 800;
        color: #1b3650;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        font-weight: 800;
        color: #1b3650;
        padding-right: 2.2rem;
    }

    .safety-banner {
        background-color: #d1e2ec;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        color: #1b3650;
        width: 100%;
    }

    .safety-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }

    .safety-icon svg {
        width: 100%;
        height: 100%;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .safety-text {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .safety-title {
        font-weight: 800;
        font-size: 0.95rem;
    }

    .safety-desc {
        font-size: 0.85rem;
        font-weight: 500;
        color: #4a657c;
        line-height: 1.3;
    }

    /* Right Content Styles */
    .cards-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        justify-content: space-between;
        height: 100%;
    }

    .info-card {
        background-color: #d1e2ec;
        border-radius: 16px;
        padding: 2rem 2.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .card-icon {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        margin-top: 0.3rem;
    }

    .card-icon svg {
        width: 100%;
        height: 100%;
        fill: #1b3650;
    }

    .card-content {
        flex-grow: 1;
        color: #1b3650;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #1b3650;
    }

    .card-text {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.4;
        color: #334b61;
    }

    .standards-row {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-weight: 800;
        font-size: 1rem;
        margin-top: 1.5rem;
    }

    .standard-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .standard-minsal { color: #2e7d32; }
    .standard-oms { color: #1b3650; }

    .standard-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .standard-icon svg {
        width: 24px;
        height: 24px;
    }

    .standard-minsal svg { fill: none; stroke: #2e7d32; stroke-width: 2; stroke-linecap: round; }
    .standard-oms svg { fill: none; stroke: #1b3650; stroke-width: 2; stroke-linecap: round; }

    /* Color Legend Row (First Card) */
    .color-legend-row {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-weight: 700;
        font-size: 1.05rem;
    }

    .color-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: #1b3650;
    }

    .color-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    .circle-green { background-color: #40c41d; }
    .circle-yellow { background-color: #dfc214; }
    .circle-red { background-color: #ff0000; }

    @media (max-width: 768px) {
        .info-card {
            flex-direction: column;
            gap: 1rem;
            padding: 1.5rem;
            align-items: center;
            text-align: center;
        }
        .standards-row, .color-legend-row {
            flex-direction: column;
            gap: 0.8rem;
            align-items: center;
        }
    }
</style>
@endsection

@section('content')
@php
    $ph = isset($sensor) ? $sensor->ph_level : 7.2;
    $water_level = isset($sensor) ? $sensor->water_level : 75;
    $time_ago = isset($sensor) ? $sensor->updated_at->diffForHumans() : 'Hace 5 minutos';

    if ($ph >= 6.5 && $ph <= 8.5) {
        $phColor = '#40c41d'; // green
        $phBgColor = 'rgba(64, 196, 29, 0.15)';
        $phBorderColor = '#40c41d';
        $phTextColor = '#2e7d32';
        $phStatusText = 'Normal';
        $phIconPath = '<path d="M20 6L9 17l-5-5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>';
        
        $safetyTitle = 'El agua es apta para el consumo';
        $safetyDesc = 'Todos los parámetros dentro del rango del MINSAL';
        $safetyIconColor = '#3fbc95';
        $safetyIconPath = '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>';
    } elseif (($ph >= 6.0 && $ph < 6.5) || ($ph > 8.5 && $ph <= 9.0)) {
        $phColor = '#dfc214'; // yellow
        $phBgColor = 'rgba(223, 194, 20, 0.15)';
        $phBorderColor = '#dfc214';
        $phTextColor = '#856404';
        $phStatusText = 'Revisar';
        $phIconPath = '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="9" x2="12" y2="13" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="17" x2="12.01" y2="17" stroke-width="2" stroke-linecap="round"/>';
        
        $safetyTitle = 'Precaución con el agua';
        $safetyDesc = 'El pH del agua se encuentra ligeramente fuera del rango óptimo';
        $safetyIconColor = '#dfc214';
        $safetyIconPath = '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="12" y1="9" x2="12" y2="13" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="17" x2="12.01" y2="17" stroke-width="2" stroke-linecap="round"/>';
    } else {
        $phColor = '#ff0000'; // red
        $phBgColor = 'rgba(255, 0, 0, 0.15)';
        $phBorderColor = '#ff0000';
        $phTextColor = '#721c24';
        $phStatusText = 'Peligro';
        $phIconPath = '<circle cx="12" cy="12" r="10" stroke-width="2"/><line x1="15" y1="9" x2="9" y2="15" stroke-width="2"/><line x1="9" y1="9" x2="15" y2="15" stroke-width="2"/>';
        
        $safetyTitle = 'El agua NO es apta para el consumo';
        $safetyDesc = 'Parámetros críticos fuera de la norma del MINSAL. ¡Peligro!';
        $safetyIconColor = '#ff0000';
        $safetyIconPath = '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="9" y1="9" x2="15" y2="15" stroke-width="2" stroke-linecap="round"/><line x1="15" y1="9" x2="9" y2="15" stroke-width="2" stroke-linecap="round"/>';
    }
@endphp
<div class="page-container">
    <div class="main-layout">
        
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="ph-card">
                <div class="ph-title">PH ACTUAL</div>
                <div class="ph-value" style="color: {{ $phColor }};">{{ number_format($ph, 1) }}</div>
                <div class="ph-status" style="background-color: {{ $phBgColor }}; border-color: {{ $phBorderColor }}; color: {{ $phTextColor }};">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        {!! $phIconPath !!}
                    </svg>
                    {{ $phStatusText }}
                </div>
            </div>

            <div class="sidebar-info-group">
                <div class="info-row">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/>
                        </svg>
                    </div>
                    <div class="info-text-group">
                        <div class="info-label">Última actualización</div>
                        <div class="info-sub">{{ $time_ago }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>
                        </svg>
                    </div>
                    <div class="info-text-group">
                        <div class="info-label">Nivel de tanque</div>
                        <div class="progress-container">
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width: {{ $water_level }}%;"></div>
                                </div>
                                <div class="progress-value-text">{{ $water_level }}%</div>
                            </div>
                            <div class="progress-labels">
                                <span>0%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="safety-banner">
                <div class="safety-icon" style="color: {{ $safetyIconColor }};">
                    <svg viewBox="0 0 24 24">
                        {!! $safetyIconPath !!}
                    </svg>
                </div>
                <div class="safety-text">
                    <div class="safety-title">{{ $safetyTitle }}</div>
                    <div class="safety-desc">{{ $safetyDesc }}</div>
                </div>
            </div>
        </div>

        <!-- Main Content (Cards) -->
        <div class="cards-column">
            
            <!-- Card 1 -->
            <div class="info-card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h2 class="card-title">¿Qué significa el color del indicador?</h2>
                    <div class="color-legend-row">
                        <div class="color-item">
                            <div class="color-circle circle-green"></div>
                            Seguro
                        </div>
                        <div class="color-item">
                            <div class="color-circle circle-yellow"></div>
                            Revisar
                        </div>
                        <div class="color-item">
                            <div class="color-circle circle-red"></div>
                            No tomar
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="info-card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h2 class="card-title">¿Qué es el pH del agua?</h2>
                    <div class="card-text">
                        Mide si el agua es ácida o básica. Un pH entre 6.5 y 8.5 es seguro para tomar.
                    </div>
                    <div class="standards-row">
                        <div class="standard-item standard-minsal">
                            <div class="standard-icon">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 12l3 3 5-6"></path>
                                </svg>
                            </div>
                            MINSAL: 6.5 - 8.5
                        </div>
                        <div class="standard-item standard-oms">
                            <div class="standard-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            OMS: 6.5 - 8.5
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="info-card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 2v2h10V2H7zm2 2v5.5l-4.5 9A2 2 0 0 0 6.29 22h11.42a2 2 0 0 0 1.79-2.5L15 9.5V4H9zm2 6.5V4h2v6.5l3.5 7h-9l3.5-7z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h2 class="card-title">¿Qué es el cloro residual?</h2>
                    <div class="card-text">
                        El cloro mata bacterias en el agua. Debe estar entre 0.3 y 1.5 mg/L para ser seguro.
                    </div>
                    <div class="standards-row">
                        <div class="standard-item standard-minsal">
                            <div class="standard-icon">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 12l3 3 5-6"></path>
                                </svg>
                            </div>
                            MINSAL: 0.3 - 1.5 mg/L
                        </div>
                        <div class="standard-item standard-oms">
                            <div class="standard-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            OMS: 0.2 - 1.0 mg/L
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection