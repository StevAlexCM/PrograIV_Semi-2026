@extends('layouts.public')

@section('title', 'Alertas y Avisos - HidroVida')

@section('styles')
<style>
    .page-container {
        max-width: 900px;
        margin: 3rem auto 5rem auto;
        padding: 0 1.5rem;
    }

    .alert-card {
        border-radius: 12px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        display: flex;
        gap: 2rem;
        align-items: center;
    }
    
    .alert-icon-wrapper {
        flex-shrink: 0;
        width: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .alert-icon-wrapper svg {
        width: 80px;
        height: 80px;
    }

    .alert-content {
        flex: 1;
        font-size: 1.05rem;
        color: #1b3650;
        line-height: 1.5;
    }

    .alert-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 0.2rem;
    }

    .alert-subtitle {
        font-weight: 800;
        margin-bottom: 0.2rem;
    }

    .alert-meta {
        margin-bottom: 1rem;
    }

    .alert-meta span {
        display: block;
    }

    .alert-description {
        margin: 0;
        font-weight: 400;
    }

    .card-red {
        background-color: #ede2e2;
        border: 2px solid #d84545;
    }
    .card-red .alert-title {
        color: #d84545;
    }
    .card-red .alert-content {
        color: #000000;
    }
    .card-red .alert-icon-wrapper svg {
        fill: #ff0000;
    }

    .card-yellow {
        background-color: #f1f3d3;
        border: 2px solid #e1cf1c;
    }
    .card-yellow .alert-title {
        color: #1b3650;
    }
    .card-yellow .alert-content {
        color: #1b3650;
    }
    .card-yellow .alert-icon-wrapper svg {
        fill: #eada14;
    }

    .card-blue {
        background-color: #eef6fc;
        border: 2px solid #299bc4;
    }
    .card-blue .alert-title {
        color: #1a5c8b;
    }
    .card-blue .alert-content {
        color: #1b3650;
    }
    .card-blue .alert-icon-wrapper svg {
        fill: #299bc4;
    }

    @media (max-width: 768px) {
        .alert-card {
            flex-direction: column;
            text-align: left;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
        }
        .alert-icon-wrapper {
            width: auto;
        }
        .alert-icon-wrapper svg {
            width: 50px;
            height: 50px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">

    @if(count($alertas) == 0)
        <div class="text-center" style="padding: 4rem; color: #6a8ba3;">
            <i class="bi bi-bell-slash" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
            <h4>No hay alertas activas en este momento.</h4>
        </div>
    @else
        @foreach($alertas as $alerta)
            <div class="alert-card card-{{ $alerta->tipo }}">
                <div class="alert-icon-wrapper">
                    @if($alerta->tipo == 'red')
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2L1 21h22L12 2zm0 3.8l7.5 13.2H4.5L12 5.8z" fill="none"/>
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    @elseif($alerta->tipo == 'blue')
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    @else
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        <path d="M22 13c0-3.5-1.5-6.6-3.8-8.7l-1.4 1.4C18.6 7.4 20 9.8 20 13h2z" fill="#eada14" />
                        <path d="M5.8 5.7L4.4 4.3C2.1 6.4 0.6 9.5 0.6 13h2c0-3.2 1.4-5.6 3.2-7.3z" fill="#eada14" />
                    </svg>
                    @endif
                </div>
                <div class="alert-content">
                    <div class="alert-title">{{ $alerta->titulo }}</div>
                    @php
                        $fechaDisplay = $alerta->fecha_texto;
                        try {
                            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $alerta->fecha_texto)) {
                                $date = \Carbon\Carbon::parse($alerta->fecha_texto);
                                $fechaDisplay = $date->isoFormat('dddd D [de] MMMM [de] YYYY, h:mm A');
                                $fechaDisplay = ucfirst($fechaDisplay);
                            }
                        } catch (\Exception $e) {}
                    @endphp
                    <div class="alert-subtitle">{{ $fechaDisplay }}</div>
                    <div class="alert-meta">
                        <span><strong>Zona afectada:</strong> {{ $alerta->zona }}</span>
                        <span><strong>Motivo:</strong> {{ $alerta->motivo }}</span>
                    </div>
                    @if($alerta->descripcion)
                    <p class="alert-description">
                        {{ $alerta->descripcion }}
                    </p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection
