@extends('layouts.public')

@section('title', 'Calidad del agua - HidroVida')

@section('styles')
<style>
        .page-container {
            max-width: 800px;
            margin: 4rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .ph-card {
            background-color: #c9dbe6;
            border-radius: 16px;
            padding: 3rem 4rem;
            text-align: center;
            width: 100%;
            max-width: 480px;
            margin: 0 auto 4rem auto;
        }
        .ph-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1b3650;
            margin-bottom: 0.5rem;
        }
        .ph-value {
            font-size: 6rem;
            font-weight: 800;
            color: #31c21c;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .ph-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #a7c5d9;
            padding: 0.4rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            color: #31c21c;
            border: 1px solid rgba(255,255,255,0.4);
            font-size: 1.1rem;
        }
        .ph-status i {
            font-size: 1.3rem;
        }

        .details-section {
            width: 100%;
            max-width: 750px;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            margin: 0 auto;
        }

        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 1.2rem;
        }
        .detail-icon {
            font-size: 2.2rem;
            color: #1b3650;
            line-height: 1;
            padding-top: 0.2rem;
        }
        .detail-text h4 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1b3650;
            margin-bottom: 0.2rem;
        }
        .detail-text p {
            font-size: 1.15rem;
            font-weight: 500;
            color: #1b3650;
            opacity: 0.9;
            margin: 0;
        }

        .progress-wrapper {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
            width: 100%;
        }
        .progress-bar-container {
            flex: 1;
            height: 28px;
            background-color: white;
            border: 2px solid #1b3650;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            background-color: #1b3650;
            width: 75%; /* Hardcoded 75% */
            border-radius: 12px 0 0 12px;
        }
        .progress-text {
            font-weight: 800;
            font-size: 1.4rem;
            color: #6a8ba3; /* Greyish blue */
            min-width: 60px;
        }

</style>
@endsection

@section('content')
@php
    $ph = isset($sensor) ? $sensor->ph_level : 7.2;
    $nivel = isset($sensor) ? $sensor->water_level : 75;
    $time_ago = isset($sensor) ? str_replace('hace ', 'Hace ', $sensor->updated_at->diffForHumans()) : 'Hace 5 minutos';
    
    
    $statusColor = '#40c41d'; 
    $statusText = 'Normal - Segura';
    $statusIcon = 'bi-check-circle';

    if ($ph >= 6.5 && $ph <= 8.5) {
        $statusColor = '#40c41d';
        $statusText = 'Normal - Segura';
        $statusIcon = 'bi-check-circle';
    } elseif (($ph >= 6.0 && $ph < 6.5) || ($ph > 8.5 && $ph <= 9.0)) {
        $statusColor = '#dfc214'; 
        $statusText = 'Revisar';
        $statusIcon = 'bi-exclamation-triangle';
    } else {
        $statusColor = '#ff0000'; 
        $statusText = 'No apta para consumo';
        $statusIcon = 'bi-x-octagon';
    }
@endphp

    <div class="page-container">
        
        
        <div class="ph-card">
            <div class="ph-title">PH ACTUAL</div>
            <div class="ph-value" style="color: {{ $statusColor }};">{{ number_format($ph, 1) }}</div>
            <div class="ph-status" style="color: {{ $statusColor }}; border-color: {{ $statusColor }}80; background-color: {{ $statusColor }}10;">
                <i class="bi {{ $statusIcon }}"></i> {{ $statusText }}
            </div>
        </div>

        <div class="details-section">
            
            <div class="detail-row">
                <div class="detail-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
                <div class="detail-text">
                    <h4>Ultima actualizacion</h4>
                    <p>{{ strtolower($time_ago) }}</p>
                </div>
            </div>

            
            <div class="detail-row" style="flex-direction: column; gap: 0;">
                <div style="display: flex; gap: 1.2rem; align-items: flex-start; width: 100%;">
                    <div class="detail-icon">
                        <i class="bi bi-droplet-fill"></i>
                    </div>
                    <div class="detail-text" style="padding-top: 0.2rem;">
                        <h4>Nivel de tanque</h4>
                    </div>
                </div>
                
                <div class="progress-wrapper" style="align-items: flex-start;">
                    <div style="flex: 1;">
                        <div class="progress-bar-container">
                            <div class="progress-fill" style="width: {{ $nivel }}%;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.8rem; font-weight: 800; color: #5a7b91; font-size: 1.1rem;">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                    <div class="progress-text" style="line-height: 28px;">{{ $nivel }}%</div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
@endsection
