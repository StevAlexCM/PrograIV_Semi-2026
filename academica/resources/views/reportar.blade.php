@extends('layouts.public')

@section('title', 'Reportar un problema - HidroVida')

@section('styles')
<style>
    .page-container {
        max-width: 900px;
        margin: 3rem auto 5rem auto;
        padding: 0 1.5rem;
    }

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
        
        
        <h2 class="section-title">Categoría del problema</h2>
        <p class="section-subtitle">Selecciona la categoría que mejor describe el problema</p>
        
        <div class="categories-grid">
            
            <label class="category-option">
                <input type="radio" name="categoria" value="agua_sucia" checked>
                <div class="category-label">
                    <svg viewBox="0 0 100 100" width="60" height="60">
                        
                        <path d="M50 10 C50 10, 20 45, 20 65 A30 30 0 0 0 80 65 C80 45, 50 10, 50 10 Z" fill="white"></path>
                        
                        <path d="M55 85 A20 20 0 0 0 72 65" fill="none" stroke="#255f84" stroke-width="6" stroke-linecap="round"></path>
                    </svg>
                    Agua sucia
                </div>
            </label>

            
            <label class="category-option">
                <input type="radio" name="categoria" value="mal_olor">
                <div class="category-label">
                    <svg viewBox="0 0 100 100" width="60" height="60">
                        
                        <path d="M25 80 C 15 60, 45 40, 30 10 C 40 30, 10 50, 25 80 Z" fill="white"></path>
                        <path d="M50 90 C 40 70, 70 50, 55 20 C 65 40, 35 60, 50 90 Z" fill="white"></path>
                        <path d="M75 80 C 65 60, 95 40, 80 10 C 90 30, 60 50, 75 80 Z" fill="white"></path>
                    </svg>
                    Mal olor
                </div>
            </label>

            
            <label class="category-option">
                <input type="radio" name="categoria" value="tuberia_rota">
                <div class="category-label">
                    <svg viewBox="0 0 100 100" width="60" height="60">
                        
                        <path d="M10 35 H45 L55 45 L40 55 H10 Z" fill="white"></path>
                        <path d="M10 25 H15 V65 H10 Z" fill="white"></path>
                        
                        <path d="M90 35 H60 L50 45 L65 55 H90 Z" fill="white"></path>
                        <path d="M90 25 H85 V65 H90 Z" fill="white"></path>
                        
                        <path d="M50 65 C50 65, 42 80, 42 88 A8 8 0 0 0 58 88 C58 80, 50 65, 50 65 Z" fill="white"></path>
                    </svg>
                    Tubería rota
                </div>
            </label>

            
            <label class="category-option">
                <input type="radio" name="categoria" value="sin_agua">
                <div class="category-label">
                    <svg viewBox="0 0 100 100" width="60" height="60">
                        
                        <path d="M40 10 C40 10, 15 45, 15 65 A25 25 0 0 0 52 89" fill="#e6e6e6"></path>
                        
                        <path d="M60 55 L90 85 M90 55 L60 85" fill="none" stroke="#e6e6e6" stroke-width="12" stroke-linecap="round"></path>
                    </svg>
                    Sin agua
                </div>
            </label>
        </div>

        
        <div class="form-group">
            <h2 class="section-title">Detalles del problema *</h2>
            <p class="section-subtitle">Cuentanos más detalles ¿Qué sucedio específicamente?</p>
            <textarea id="descripcion" name="descripcion" class="custom-input" placeholder="Cuentanos mas detalles ¿que sucedio especificamente?"></textarea>
        </div>

        
        <div class="form-group">
            <h2 class="section-title">Ubicación *</h2>
            <p class="section-subtitle">Indica el lugar donde ocurre el problema</p>
            <div class="location-row">
                <input type="text" id="sector_manzana_calle" name="sector_manzana_calle" class="custom-input" placeholder="Sector/casa/calle/referencia">
                <button type="button" class="btn-location" onclick="obtenerUbicacion()"><i class="bi bi-crosshair"></i> Usar mi ubicación</button>
            </div>
        </div>

        
        <div class="form-group">
            <h2 class="section-title">Tu información de contacto *</h2>
            <p class="section-subtitle">Para que podamos informarte sobre el seguimiento</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="nombre_contacto" name="nombre_contacto" class="custom-input" placeholder="Nombre completo">
                </div>
                <div class="col-md-6">
                    <input type="text" id="telefono_contacto" name="telefono_contacto" class="custom-input" placeholder="Número de teléfono">
                </div>
            </div>
        </div>

        
        <div class="actions-row">
            <button type="submit" class="btn-send" id="btnSubmit">ENVIAR</button>
            <button type="reset" class="btn-cancel">CANCELAR</button>
        </div>

        
        <div class="info-banner">
            <i class="bi bi-shield-check"></i>
            <span>La directiva recibira el mensaje inmediatamente. Un encargado se comunicara contigo para el seguimiento</span>
        </div>

    </form>
</div>


<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    async function enviarReporte(e) {
        e.preventDefault();

        @if(!session()->has('usuario_id') && !session()->has('admin_id'))
        window.location.href = '/login';
        return;
        @endif

        const btnSubmit = document.getElementById('btnSubmit');
        const form = document.getElementById('reporteForm');
        
        const formData = new FormData(form);
        const nombre = formData.get('nombre_contacto') ? formData.get('nombre_contacto').trim() : '';
        const telefono = formData.get('telefono_contacto') ? formData.get('telefono_contacto').trim() : '';

        if (!nombre) {
            alertify.error('Por favor ingresa tu nombre.');
            return;
        }
        if (!telefono) {
            alertify.error('Por favor ingresa tu número de teléfono.');
            return;
        }
        if (!formData.get('sector_manzana_calle')) {
            alertify.error('Por favor ingresa tu ubicación.');
            return;
        }

        const data = {
            categoria_de_problema: formData.get('categoria'),
            descripcion: formData.get('descripcion'),
            numero_casa: 'N/A', // Set to N/A as requested by new design 
            sector_manzana_calle: formData.get('sector_manzana_calle'),
            Informacion_de_contacto: `${nombre} - ${telefono}`
        };

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

    function obtenerUbicacion() {
        const input = document.getElementById('sector_manzana_calle');
        const btn = document.querySelector('.btn-location');
        
        if (!navigator.geolocation) {
            alertify.error('La geolocalización no es compatible con este navegador.');
            return;
        }

        const originalBtnContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Obteniendo...';
        input.value = 'Obteniendo ubicación...';

        navigator.geolocation.getCurrentPosition(
            async (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`, {
                        headers: {
                            'Accept-Language': 'es'
                        }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        input.value = data.display_name || `Lat: ${lat.toFixed(6)}, Lng: ${lon.toFixed(6)}`;
                        alertify.success('Ubicación obtenida correctamente.');
                    } else {
                        input.value = `Lat: ${lat.toFixed(6)}, Lng: ${lon.toFixed(6)}`;
                    }
                } catch (error) {
                    console.error('Error in reverse geocoding:', error);
                    input.value = `Lat: ${lat.toFixed(6)}, Lng: ${lon.toFixed(6)}`;
                    alertify.success('Coordenadas obtenidas (error al traducir dirección).');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnContent;
                }
            },
            (error) => {
                btn.disabled = false;
                btn.innerHTML = originalBtnContent;
                input.value = '';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        alertify.error('Permiso denegado para obtener la ubicación.');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alertify.error('La información de ubicación no está disponible.');
                        break;
                    case error.TIMEOUT:
                        alertify.error('Tiempo de espera agotado al obtener la ubicación.');
                        break;
                    default:
                        alertify.error('Ocurrió un error al obtener la ubicación.');
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
</script>
@endsection
