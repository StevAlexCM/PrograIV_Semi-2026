import os

content = """@extends('layouts.public')

@section('title', 'Reportar un problema - HidroVida')

@section('styles')
<style>
    /* Main Layout */
    .page-container {
        max-width: 900px;
        margin: 3rem auto 5rem auto;
        padding: 0 1.5rem;
    }

    /* Typography */
    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1b3650;
        margin-bottom: 0.1rem;
    }
    .section-subtitle {
        font-size: 1rem;
        font-weight: 500;
        color: #4a657c;
        margin-bottom: 1.5rem;
    }

    /* Category Buttons */
    .categories-grid {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }
    .category-option {
        position: relative;
        flex: 1;
        min-width: 140px;
    }
    .category-option input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .category-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        background-color: #255f84;
        color: white;
        border-radius: 12px;
        padding: 2rem 1rem;
        cursor: pointer;
        transition: all 0.3s;
        height: 100%;
        text-align: center;
        font-weight: 500;
        font-size: 1.1rem;
        border: 3px solid transparent;
    }
    .category-label svg {
        width: 40px;
        height: 40px;
        color: white;
        fill: white;
    }
    .category-option input:checked + .category-label {
        background-color: #1b4b6b;
        border-color: #89b3d0;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(27, 75, 107, 0.3);
    }
    .category-label:hover {
        background-color: #1b4b6b;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 2.5rem;
    }
    .custom-input {
        width: 100%;
        padding: 1rem 1.2rem;
        background-color: #e8ecef;
        border: 1px solid #7a94a7;
        border-radius: 8px;
        font-size: 1rem;
        color: #1b3650;
        transition: border-color 0.3s;
    }
    .custom-input::placeholder {
        color: #a0b3c1;
        font-weight: 600;
    }
    .custom-input:focus {
        outline: none;
        border-color: #1b3650;
        background-color: #f1f4f6;
    }
    textarea.custom-input {
        min-height: 120px;
        resize: vertical;
    }

    /* Location Row */
    .location-row {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    .location-row .custom-input {
        flex: 1;
    }
    .btn-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #e8ecef;
        border: 1px solid #1b3650;
        color: #1b3650;
        font-weight: 800;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }
    .btn-location:hover {
        background-color: #d1d9df;
    }
    .btn-location i {
        font-size: 1.2rem;
        margin-top: -2px;
    }

    /* Action Buttons */
    .actions-row {
        display: flex;
        justify-content: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    .btn-send, .btn-cancel {
        padding: 0.8rem 2.5rem;
        border-radius: 8px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
    }
    .btn-send {
        background-color: #2a7e18;
        color: white;
    }
    .btn-send:hover { background-color: #1f6111; }
    
    .btn-cancel {
        background-color: #fc6565;
        color: white;
        border: 1px solid #d43b3b;
    }
    .btn-cancel:hover { background-color: #e0484d; }

    /* Bottom Info Banner */
    .info-banner {
        background-color: #bcd0de;
        border-radius: 12px;
        padding: 1.2rem 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        color: #4a657c;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .info-banner i {
        color: #3fbc95;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .categories-grid { gap: 1rem; }
        .category-option { min-width: 45%; }
        .location-row { flex-direction: column; }
        .btn-location { width: 100%; justify-content: center; }
        .actions-row { flex-direction: column; }
        .btn-send, .btn-cancel { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <form id="reporteForm" onsubmit="enviarReporte(event)">
        @csrf
        
        <!-- Categoría del problema -->
        <h2 class="section-title">Categoría del problema</h2>
        <p class="section-subtitle">Selecciona la categoría que mejor describe el problema</p>
        
        <div class="categories-grid">
            <!-- Agua sucia -->
            <label class="category-option">
                <input type="radio" name="categoria" value="agua_sucia" checked>
                <div class="category-label">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-5.5c-.5 1.5-2 3.9-4 5.5S5 13 5 15a7 7 0 0 0 7 7z"></path>
                    </svg>
                    Agua sucia
                </div>
            </label>

            <!-- Sin agua -->
            <label class="category-option">
                <input type="radio" name="categoria" value="sin_agua">
                <div class="category-label">
                    <svg viewBox="0 0 24 24">
                        <!-- Custom icon for water drop with X -->
                        <path d="M12 2C12 2 7 9 7 14A5 5 0 0 0 17 14C17 12.5 16.2 10.5 15 8" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"></path>
                        <line x1="13" y1="17" x2="19" y2="11" stroke="white" stroke-width="2" stroke-linecap="round"></line>
                        <line x1="19" y1="17" x2="13" y2="11" stroke="white" stroke-width="2" stroke-linecap="round"></line>
                    </svg>
                    Sin agua
                </div>
            </label>

            <!-- Mal olor -->
            <label class="category-option">
                <input type="radio" name="categoria" value="mal_olor">
                <div class="category-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round">
                        <path d="M8 4c0 3-4 6-4 10a4 4 0 0 0 8 0c0-3-4-6-4-10z"></path>
                        <path d="M16 8c0 2.5-3 5-3 8.5a3.5 3.5 0 0 0 7 0C20 13 17 10.5 16 8z"></path>
                    </svg>
                    Mal olor
                </div>
            </label>

            <!-- Tubería rota -->
            <label class="category-option">
                <input type="radio" name="categoria" value="tuberia_rota">
                <div class="category-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round">
                        <rect x="2" y="8" width="20" height="8" rx="1"></rect>
                        <line x1="10" y1="6" x2="10" y2="18"></line>
                        <line x1="14" y1="6" x2="14" y2="18"></line>
                        <path d="M12 16v4" stroke-width="2"></path>
                        <circle cx="12" cy="22" r="1.5" fill="white" stroke="none"></circle>
                    </svg>
                    Tubería rota
                </div>
            </label>
        </div>

        <!-- Detalles del problema -->
        <div class="form-group">
            <h2 class="section-title">Detalles del problema *</h2>
            <p class="section-subtitle">Cuentanos más detalles ¿Qué sucedio específicamente?</p>
            <textarea id="descripcion" name="descripcion" class="custom-input" placeholder="Cuentanos mas detalles ¿que sucedio especificamente?"></textarea>
        </div>

        <!-- Ubicación -->
        <div class="form-group">
            <h2 class="section-title">Ubicación *</h2>
            <p class="section-subtitle">Indica el lugar donde ocurre el problema</p>
            <div class="location-row">
                <input type="text" id="sector_manzana_calle" name="sector_manzana_calle" class="custom-input" placeholder="Sector/casa/calle/referencia">
                <button type="button" class="btn-location"><i class="bi bi-crosshair"></i> Usar mi ubicación</button>
            </div>
        </div>

        <!-- Contacto -->
        <div class="form-group">
            <h2 class="section-title">Tu información de contacto *</h2>
            <p class="section-subtitle">Para que podamos informarte sobre el seguimiento</p>
            <input type="text" id="contacto" name="Informacion_de_contacto" class="custom-input" placeholder="Tu nombre y telefono">
        </div>

        <!-- Action Buttons -->
        <div class="actions-row">
            <button type="submit" class="btn-send" id="btnSubmit">ENVIAR</button>
            <button type="reset" class="btn-cancel">CANCELAR</button>
        </div>

        <!-- Info Banner -->
        <div class="info-banner">
            <i class="bi bi-shield-check"></i>
            <span>La directiva recibira el mensaje inmediatamente. Un encargado se comunicara contigo para el seguimiento</span>
        </div>

    </form>
</div>

<!-- AlertifyJS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    async function enviarReporte(e) {
        e.preventDefault();

        @if(!session()->has('usuario_id') && !session()->has('admin_id'))
        if (localStorage.getItem('reporte_enviado')) {
            alertify.alert('Registro necesario', 'Solo puedes enviar un reporte sin estar registrado. Por favor, regístrate para enviar más reportes y darles seguimiento.');
            return;
        }
        @endif

        const btnSubmit = document.getElementById('btnSubmit');
        const form = document.getElementById('reporteForm');
        
        const formData = new FormData(form);
        const data = {
            categoria_de_problema: formData.get('categoria'),
            descripcion: formData.get('descripcion'),
            numero_casa: 'N/A', // Set to N/A as requested by new design 
            sector_manzana_calle: formData.get('sector_manzana_calle'),
            Informacion_de_contacto: formData.get('Informacion_de_contacto')
        };

        if (!data.sector_manzana_calle) {
            alertify.error('Por favor ingresa tu ubicación.');
            return;
        }

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = 'Enviando...';

        try {
            const response = await fetch('/reporte', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.msg === 'ok') {
                alertify.success('Reporte enviado correctamente.');
                form.reset();

                @if(!session()->has('usuario_id') && !session()->has('admin_id'))
                localStorage.setItem('reporte_enviado', 'true');
                @endif
            } else {
                alertify.error('Error al enviar: ' + result.msg);
            }
        } catch (error) {
            console.error(error);
            alertify.error('Error de conexión al enviar el reporte.');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'ENVIAR';
        }
    }
</script>
@endsection
"""

with open('resources/views/reportar.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Done writing reportar.blade.php')
