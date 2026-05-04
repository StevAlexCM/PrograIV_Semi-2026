<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportar un problema - HidroVida</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-dark: #1b3650;
            --text-dark: #2d3748;
            --text-gray: #718096;
            --border-color: #cbd5e0;
            --input-bg: #ffffff;
            --btn-green: #38a169;
            --btn-green-hover: #2f855a;
            --bg-color: #f7fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-dark); -webkit-font-smoothing: antialiased; }
        
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
            background: rgba(255, 255, 255, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
        }
        .header-logo:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }
        .header-title {
            font-size: 1.1rem;
            font-weight: 600;
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
            max-width: 850px;
            margin: 2.5rem auto 4rem auto;
            padding: 0 1rem;
        }

        .form-card {
            background-color: white;
            border-radius: 20px;
            padding: 2.5rem 3.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .form-title {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 2rem;
            color: var(--primary-dark);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
            color: var(--primary-dark);
        }

        /* Radio Buttons (Categorías) */
        .categories-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .category-option {
            position: relative;
        }
        .category-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .category-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.8rem 1.2rem;
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.2s;
        }
        .category-label svg {
            width: 24px;
            height: 24px;
            color: #64748b;
        }
        .category-label .check-icon {
            display: none;
            color: #0284c7;
            font-size: 1.1rem;
            margin-right: -4px;
        }
        
        .category-option input:checked + .category-label {
            background-color: #e0f2fe;
            border-color: #0ea5e9;
            color: #0369a1;
        }
        .category-option input:checked + .category-label svg.main-icon {
            color: #0284c7;
            /* For the dirty water icon, we might want to keep the fill */
        }
        .category-option input:checked + .category-label .check-icon {
            display: inline-block;
        }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--text-dark);
            background-color: var(--input-bg);
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234a5568' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background-color: var(--btn-green);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(56, 161, 105, 0.2);
        }
        .btn-submit:hover {
            background-color: var(--btn-green-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(56, 161, 105, 0.3);
        }

        .form-footer-text {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-gray);
            margin-top: 1.2rem;
            line-height: 1.5;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .header { padding: 1rem; }
            .form-card { padding: 2rem 1.5rem; }
            .categories-grid { flex-direction: column; }
            .category-label { width: 100%; justify-content: flex-start; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="/" class="header-logo" title="Volver al inicio">
            <i class="bi bi-house-door-fill"></i>
        </a>
        <div class="header-title">Reportar un problema</div>
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
        <div class="form-card">
            <h2 class="form-title">Reportar un problema</h2>

            <form id="reporteForm" onsubmit="enviarReporte(event)">
                @csrf
                <!-- Categoría -->
                <div class="form-group">
                    <label class="form-label">Categoría del problema</label>
                    <div class="categories-grid">
                        
                        <!-- Agua sucia -->
                        <label class="category-option">
                            <input type="radio" name="categoria" value="agua_sucia" checked>
                            <div class="category-label">
                                <i class="bi bi-check-circle-fill check-icon"></i>
                                <svg class="main-icon" width="24" height="24" viewBox="0 0 24 24" fill="#d4b595" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-5.5c-.5 1.5-2 3.9-4 5.5S5 13 5 15a7 7 0 0 0 7 7z" fill="#d4b595"></path>
                                    <circle cx="10" cy="16" r="1.5" fill="#8b5a2b" stroke="none"></circle>
                                    <circle cx="14" cy="18" r="1" fill="#8b5a2b" stroke="none"></circle>
                                    <circle cx="12" cy="13" r="1" fill="#8b5a2b" stroke="none"></circle>
                                </svg>
                                Agua sucia
                            </div>
                        </label>

                        <!-- Sin agua -->
                        <label class="category-option">
                            <input type="radio" name="categoria" value="sin_agua">
                            <div class="category-label">
                                <i class="bi bi-check-circle-fill check-icon"></i>
                                <svg class="main-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 4v4M12 8h-4a2 2 0 0 0-2 2v2M6 12h10a2 2 0 0 0 2-2V8h-4M10 20a2 2 0 1 0 4 0 2 2 0 1 0-4 0z"></path>
                                    <line x1="12" y1="14" x2="12" y2="16"></line>
                                </svg>
                                Sin agua
                            </div>
                        </label>

                        <!-- Mal olor -->
                        <label class="category-option">
                            <input type="radio" name="categoria" value="mal_olor">
                            <div class="category-label">
                                <i class="bi bi-check-circle-fill check-icon"></i>
                                <svg class="main-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 14a4 4 0 0 1 4-4 4 4 0 0 0 4-4 4 4 0 0 1 4-4"></path>
                                    <path d="M4 22a4 4 0 0 1 4-4 4 4 0 0 0 4-4 4 4 0 0 1 4-4"></path>
                                    <path d="M12 22a4 4 0 0 1 4-4 4 4 0 0 0 4-4 4 4 0 0 1 4-4"></path>
                                </svg>
                                Mal olor
                            </div>
                        </label>

                        <!-- Tubería rota -->
                        <label class="category-option">
                            <input type="radio" name="categoria" value="tuberia_rota">
                            <div class="category-label">
                                <i class="bi bi-check-circle-fill check-icon"></i>
                                <svg class="main-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="8" width="20" height="8" rx="2"></rect>
                                    <line x1="8" y1="8" x2="8" y2="16"></line>
                                    <line x1="16" y1="8" x2="16" y2="16"></line>
                                    <path d="M12 16v3"></path>
                                    <circle cx="12" cy="21" r="1.5" fill="currentColor"></circle>
                                    <circle cx="15" cy="19" r="1" fill="currentColor"></circle>
                                </svg>
                                Tubería rota
                            </div>
                        </label>

                    </div>
                </div>

                <!-- Detalles -->
                <div class="form-group">
                    <label class="form-label" for="descripcion">Detalles del problema <span style="font-weight: 400; color: #718096;">(opcional)</span></label>
                    <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Cuéntanos más detalles. ¿Qué sucedió específicamente? ¿Desde cuándo?"></textarea>
                </div>

                <!-- Ubicación -->
                <div class="form-group">
                    <label class="form-label">Tu ubicación</label>
                    <input type="text" id="numero_casa" name="numero_casa" class="form-control" placeholder="Número de casa" style="margin-bottom: 0.8rem;">
                    <select id="sector_manzana_calle" name="sector_manzana_calle" class="form-control">
                        <option value="" disabled selected>Sector / Manzana / Calle</option>
                        <option value="Sector A - Manzana 1">Sector A - Manzana 1</option>
                        <option value="Sector A - Manzana 2">Sector A - Manzana 2</option>
                        <option value="Sector B - Manzana 1">Sector B - Manzana 1</option>
                    </select>
                </div>

                <!-- Contacto -->
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label class="form-label" for="contacto">Tu información de contacto <span style="font-weight: 400; color: #718096;">(opcional)</span></label>
                    <input type="text" id="contacto" name="Informacion_de_contacto" class="form-control" placeholder="Tu nombre y/o teléfono">
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="btn-submit" id="btnSubmit">Enviar reporte</button>

                <!-- Pie de nota -->
                <p class="form-footer-text">
                    Tu directiva recibirá este reporte de inmediato. Un encargado se comunicará contigo<br>para el seguimiento.
                </p>

            </form>
        </div>
    </main>

    <!-- AlertifyJS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <script>
        async function enviarReporte(e) {
            e.preventDefault();

            @if(!session()->has('usuario_id') && !session()->has('admin_id'))
            // Verificar si el usuario no registrado ya envió un reporte
            if (localStorage.getItem('reporte_enviado')) {
                alertify.alert('Registro necesario', 'Solo puedes enviar un reporte sin estar registrado. Por favor, regístrate para enviar más reportes y darles seguimiento.');
                return;
            }
            @endif

            const btnSubmit = document.getElementById('btnSubmit');
            const form = document.getElementById('reporteForm');
            
            // Recopilar datos
            const formData = new FormData(form);
            const data = {
                categoria_de_problema: formData.get('categoria'),
                descripcion: formData.get('descripcion'),
                numero_casa: formData.get('numero_casa'),
                sector_manzana_calle: formData.get('sector_manzana_calle'),
                Informacion_de_contacto: formData.get('Informacion_de_contacto')
            };

            // Validar campos (básico)
            if (!data.numero_casa || !data.sector_manzana_calle) {
                alertify.error('Por favor ingresa tu número de casa y sector.');
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
                    alertify.success('Reporte enviado correctamente. Tu directiva lo ha recibido.');
                    form.reset();

                    @if(!session()->has('usuario_id') && !session()->has('admin_id'))
                    // Guardar en localStorage que este dispositivo ya envió un reporte
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
                btnSubmit.innerHTML = 'Enviar reporte';
            }
        }
    </script>
</body>
</html>
