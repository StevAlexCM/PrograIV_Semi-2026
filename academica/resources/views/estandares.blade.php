@extends('layouts.public')

@section('title', 'Información y Estándares - HidroVida')

@section('styles')
<style>
    .page-container {
        max-width: 900px;
        margin: 3rem auto 5rem auto;
        padding: 0 1.5rem;
    }

    /* Info Card */
    .info-card {
        background-color: #bcd0de;
        border-radius: 16px;
        padding: 2.5rem 3rem;
        display: flex;
        align-items: center;
        gap: 3rem;
        margin-bottom: 2.5rem;
    }
    
    .card-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
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
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 1.2rem;
        color: #1b3650;
    }

    .card-text {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.2rem;
        line-height: 1.5;
        color: #1b3650;
    }

    
    .standards-row {
        display: flex;
        align-items: center;
        gap: 3rem;
        font-weight: 700;
        font-size: 1.1rem;
    }
    .standard-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
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
        gap: 2.5rem;
        font-weight: 700;
        font-size: 1.1rem;
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

    /* Bottom Banner */
    .info-banner {
        background-color: #bcd0de;
        border-radius: 20px;
        padding: 1.2rem 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        color: #4a657c;
        font-weight: 500;
        font-size: 0.95rem;
        margin-top: 1rem;
    }
    .info-banner i {
        color: #3fbc95;
        font-size: 1.8rem;
    }

    @media (max-width: 768px) {
        .info-card {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
            padding: 2rem 1.5rem;
        }
        .standards-row, .color-legend-row {
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    
    
    <div class="info-card">
        <div class="card-icon">
            
            <svg viewBox="0 0 100 100">
                <path d="M50 10 C50 10, 20 45, 20 65 A30 30 0 0 0 80 65 C80 45, 50 10, 50 10 Z" fill="#1b3650"></path>
                
                <path d="M55 85 A20 20 0 0 0 72 65" fill="none" stroke="#eef8fb" stroke-width="4" stroke-linecap="round"></path>
            </svg>
        </div>
        <div class="card-content">
            <h2 class="card-title">¿Qué significa el color del indicador?</h2>
            <div class="color-legend-row">
                <div class="color-item">
                    <div class="color-circle circle-green"></div>
                    Verde = Seguro
                </div>
                <div class="color-item">
                    <div class="color-circle circle-yellow"></div>
                    Amarillo = Revisar
                </div>
                <div class="color-item">
                    <div class="color-circle circle-red"></div>
                    Rojo = No tomar
                </div>
            </div>
        </div>
    </div>

    
    <div class="info-card">
        <div class="card-icon">
            
            <svg viewBox="0 0 100 100">
                <path d="M50 10 C50 10, 20 45, 20 65 A30 30 0 0 0 80 65 C80 45, 50 10, 50 10 Z" fill="#1b3650"></path>
                <path d="M55 85 A20 20 0 0 0 72 65" fill="none" stroke="#eef8fb" stroke-width="4" stroke-linecap="round"></path>
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
                    <a href="https://www.salud.gob.sv" class="text-decoration-none text-black">MINSAL</a>
                </div>
                <div class="standard-item standard-oms">
                    <div class="standard-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    OMS: 6.5 - 8.5
                    <a href="https://www.who.int/es/news-room/fact-sheets/detail/drinking-water" class="text-decoration-none text-black">OMS</a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="info-card">
        <div class="card-icon">
            
            <svg viewBox="0 0 100 100">
                <path d="M40 15 h20 v20 l25 45 a8 8 0 0 1 -7 10 h-56 a8 8 0 0 1 -7 -10 l25 -45 v-20 z" fill="#1b3650"></path>
                
                <path d="M35 15 h30 v-5 h-30 z" fill="#1b3650"></path>
            </svg>
        </div>
        <div class="card-content">
            <h2 class="card-title">¿Qué es el cloro residual?</h2>
            <div class="card-text">
                El cloro mata bacterias en el agua. Debe estar entre 0.3 y 1.5 mg/L para ser seguro
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
                    <a href="https://www.salud.gob.sv" class="text-decoration-none text-black">MINSAL</a>
                </div>
                <div class="standard-item standard-oms">
                    <div class="standard-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    OMS: 0.2 - 1.0 mg/L 
                </div>
            </div>
        </div>
    </div>

    
    <div class="info-banner">
        <i class="bi bi-shield-check"></i>
        <span>Estos valores estan basados en las recomendaciones del Ministerio de Salud(MINSAL) y la Organizacion Mundial de la Saud(OMS).</span>
    </div>

</div>
@endsection
