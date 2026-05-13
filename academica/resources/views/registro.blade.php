<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - HidroVida</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>

    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #e6f3fa; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-bar {
            background-color: #70a1b9; 
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .top-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .back-btn {
            position: absolute;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .back-btn i { font-size: 2rem; }
        .back-btn span { font-size: 0.85rem; font-weight: 500; }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-box {
            background-color: #70a1b9; 
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            padding: 2.5rem 3.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(112, 161, 185, 0.3);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 1rem;
        }
        .logo-area img {
            height: 80px;
            width: auto;
        }
        
        .form-subtitle {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 2rem;
            line-height: 1.4;
        }

        .form-label {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.4rem;
            color: white;
        }

        .form-control {
            background-color: #e9ecef;
            border: none;
            border-radius: 6px !important;
            padding: 0.7rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1.2rem;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
        }

        .custom-input-group {
            position: relative;
            margin-bottom: 1.2rem;
        }
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .btn-submit {
            background-color: #1a5c8b; 
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            width: 60%;
            display: block;
            margin: 1.5rem auto 0;
        }
        .btn-submit:hover { background-color: #124368; }

        @media (max-width: 576px) {
            .login-box { padding: 2rem; }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="/login" class="back-btn">
            <i class="bi bi-house-door-fill"></i>
            <span>Inicio</span>
        </a>
        <div class="top-title">Crear cuenta</div>
    </div>

    <div class="main-content">
        <div class="login-box">
            
            <div class="logo-area">
                <img src="{{ asset('img/logo_hidrovida.png') }}" alt="Logo">
            </div>

            <div class="form-subtitle">
                Únete a HidroVida y mantente informado sobre la calidad del agua en tu comunidad.
            </div>

            <form id="registroForm">
                @csrf
                <div>
                    <label class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" name="nombre_completo" placeholder="Ej. Juan Perez" required>
                </div>

                <div>
                    <label class="form-label">Numero de cuenta</label>
                    <input type="text" class="form-control" name="correo_usuario" placeholder="0000-000-0000" required>
                </div>

                <div>
                    <label class="form-label">Sector/zona</label>
                    <input type="text" class="form-control" name="sector_zona" placeholder="Caserío/calle/número de casa" required>
                </div>

                <div>
                    <label class="form-label">Contraseña</label>
                    <div class="custom-input-group">
                        <input type="password" class="form-control mb-0" id="contraseña" name="contraseña" placeholder="**********" required>
                        <button type="button" class="toggle-password">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="regBtn">Crear cuenta</button>
            </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const pass = $('#contraseña');
                const icon = $(this).find('i');
                if (pass.attr('type') === 'password') {
                    pass.attr('type', 'text');
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
                } else {
                    pass.attr('type', 'password');
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                }
            });

            $('#registroForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#regBtn');
                btn.prop('disabled', true).text('Procesando...');

                $.ajax({
                    url: '/api/registro',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        if(res.success) {
                            alertify.success('¡Cuenta creada! Espera a que el administrador te active.');
                            setTimeout(() => window.location.href = '/login', 2000);
                        } else {
                            alertify.error(res.message || 'Error al registrar');
                            btn.prop('disabled', false).text('Crear cuenta');
                        }
                    },
                    error: function() {
                        alertify.error('Error de conexión');
                        btn.prop('disabled', false).text('Crear cuenta');
                    }
                });
            });
        });
    </script>
</body>
</html>
