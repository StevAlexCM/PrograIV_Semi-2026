@extends('layouts.public')

@section('title', 'Admin - Debug Sensores')

@section('styles')
<style>
    .admin-container {
        max-width: 600px;
        margin: 4rem auto;
        padding: 2.5rem;
        background-color: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .admin-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1b3650;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .admin-subtitle {
        text-align: center;
        color: #6a8ba3;
        margin-bottom: 2rem;
        font-weight: 500;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: #1b3650;
    }
    .form-control {
        width: 100%;
        padding: 1rem;
        border: 1px solid #c9dbe6;
        border-radius: 8px;
        font-size: 1.1rem;
        background-color: #f8fafc;
    }
    .form-control:focus {
        outline: none;
        border-color: #1b3650;
    }
    .btn-submit {
        width: 100%;
        background-color: #1b3650;
        color: white;
        border: none;
        padding: 1.2rem;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 1rem;
    }
    .btn-submit:hover {
        background-color: #122538;
    }
    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-weight: 600;
        text-align: center;
    }
    
    .sensor-guide {
        margin-top: 2rem;
        padding: 1.5rem;
        background-color: #eef8fb;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #1b3650;
    }
    .sensor-guide h4 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .sensor-guide ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    .sensor-guide li {
        margin-bottom: 0.5rem;
    }
    .text-green { color: #2e7d32; font-weight: 700; }
    .text-yellow { color: #d4a700; font-weight: 700; }
    .text-red { color: #d32f2f; font-weight: 700; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <h1 class="admin-title">Simulador de Sensores</h1>
    <p class="admin-subtitle">Modifica los valores para probar la vista de Calidad de Agua</p>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.sensores') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="ph_level">Nivel de pH actual (Ej. 7.2)</label>
            <input type="number" step="0.1" name="ph_level" id="ph_level" class="form-control" value="{{ $sensor->ph_level }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="water_level">Nivel del tanque (%)</label>
            <input type="number" name="water_level" id="water_level" class="form-control" value="{{ $sensor->water_level }}" required min="0" max="100">
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-arrow-repeat"></i> Actualizar Sensores
        </button>
    </form>

    <div class="sensor-guide">
        <h4>Guía de Indicadores de pH</h4>
        <ul>
            <li><span class="text-green">Verde (Seguro):</span> Entre 6.5 y 8.5</li>
            <li><span class="text-yellow">Amarillo (Revisar):</span> Entre 6.0 - 6.4 ó 8.6 - 9.0</li>
            <li><span class="text-red">Rojo (Peligro):</span> Menor a 6.0 ó Mayor a 9.0</li>
        </ul>
        <p style="margin-top: 1rem; font-size: 0.85rem; opacity: 0.8;">
            * Los cambios se reflejarán instantáneamente en la pestaña pública "Calidad".
        </p>
    </div>
</div>
@endsection
