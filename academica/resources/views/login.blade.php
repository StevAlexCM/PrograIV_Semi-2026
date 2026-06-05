<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - HidroVida</title>

    
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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
            transition: opacity 0.3s;
        }
        .back-btn:hover {
            opacity: 0.8;
            color: white;
        }
        .back-btn i {
            font-size: 2rem;
            line-height: 1;
        }
        .back-btn span {
            font-size: 0.85rem;
            font-weight: 500;
        }

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
            padding: 3rem 4rem;
            color: white;
            box-shadow: 0 10px 30px rgba(112, 161, 185, 0.3);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-area svg {
            width: 60px;
            height: 60px;
            fill: white;
            margin-bottom: 0.5rem;
        }
        .logo-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .form-subtitle {
            text-align: center;
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
            line-height: 1.3;
        }

        .form-label {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: white;
        }

        .custom-input-group {
            position: relative;
            margin-bottom: 0.3rem;
        }

        .form-control {
            background-color: #e9ecef;
            border: none;
            border-radius: 6px !important;
            padding: 0.8rem 1rem;
            font-size: 1.05rem;
            font-weight: 600;
            color: #495057;
            width: 100%;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
            font-weight: 600;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
            background-color: #ffffff;
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #000000;
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 10;
        }

        .input-hint {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.8);
            margin-bottom: 1.5rem;
            display: block;
        }
        
        .forgot-link {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            text-align: right;
            margin-bottom: 2rem;
        }
        .forgot-link:hover {
            color: white;
            text-decoration: underline;
        }

        .btn-submit {
            background-color: #1a5c8b;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            width: auto;
            min-width: 180px;
            display: block;
            margin: 0 auto 2.5rem auto;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #124368;
            color: white;
        }

        .footer-links {
            text-align: center;
        }
        .register-text {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .register-text a {
            color: #1a5c8b;
            text-decoration: none;
            font-weight: 800;
        }
        .register-text a:hover {
            text-decoration: underline;
        }
        .legal-links {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }
        .legal-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        .legal-links a:hover {
            color: white;
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-box {
                padding: 2rem;
            }
            .top-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="/" class="back-btn">
            <i class="bi bi-house-door-fill"></i>
            <span>Inicio</span>
        </a>
        <div class="top-title">Iniciar sesión</div>
    </div>

    <div class="main-content">
        <div class="login-box">
            
            <div class="logo-area">
                <img src="{{ asset('img/logo_blanco.svg') }}" alt="HidroVida Logo" style="height: 130px; margin-bottom: 1rem;">
            </div>

            <div class="form-subtitle">
                Inicia sesión con tu cuenta de<br>HidroVida
            </div>

            <form id="loginForm">
                @csrf
                
                <div class="mb-1">
                    <label class="form-label">Número de cuenta</label>
                    <div class="custom-input-group">
                        <input type="text" class="form-control" id="correo_usuario" name="correo_usuario" placeholder="0000-000-0000">
                    </div>
                    <span class="input-hint">Puedes encontrar tu numero de cuenta en tu recibo</span>
                </div>

                <div class="mb-1 mt-3">
                    <label class="form-label">Contraseña</label>
                    <div class="custom-input-group">
                        <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña">
                        <button type="button" class="toggle-password" tabindex="-1">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    <a href="#" class="forgot-link">¿Olvidastes tu contraseña?</a>
                </div>

                <button type="submit" class="btn-submit" id="loginBtn">Iniciar sesión</button>

            </form>

            <div class="footer-links">
                <div class="register-text">
                    ¿No tienes cuenta? <a href="{{ route('registro') }}">Registrate</a>
                </div>
                <div class="legal-links">
                    <a href="#">Terminos de uso</a>
                    <a href="#">Políticas de privacidad</a>
                </div>
            </div>

        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <script>
        $(document).ready(function() {
            // Configurar alertify
            alertify.defaults = {
                notifier: {
                    delay: 4000,
                    position: 'top-right',
                    closeButton: true
                }
            };

            // Toggle Password Visibility
            $('.toggle-password').on('click', function() {
                const passwordField = $('#contraseña');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                }
            });

            // Login Request
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); 

                const correo_usuario = $('#correo_usuario').val().trim();
                const contraseña = $('#contraseña').val();
                const token = $('meta[name="csrf-token"]').attr('content');

                if (!correo_usuario || !contraseña) {
                    alertify.error('Por favor, complete sus credenciales');
                    return;
                }

                $.ajax({
                    url: '{{ route("login") }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        correo_usuario: correo_usuario,
                        contraseña: contraseña
                    },
                    beforeSend: function() {
                        $('#loginBtn').html('Ingresando...');
                        $('#loginBtn').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success(response.message);
                            
                            const urlParams = new URLSearchParams(window.location.search);
                            const redirectUrl = urlParams.get('redirect');
                            
                            setTimeout(function() {
                                window.location.href = redirectUrl ? decodeURIComponent(redirectUrl) : response.url;
                            }, 1000);
                        } else {
                            alertify.error(response.message);
                            resetBtn();
                        }
                    },
                    error: function(xhr) {
                        alertify.error('Error de conexión o credenciales inválidas.');
                        resetBtn();
                    }
                });
            });

            function resetBtn() {
                $('#loginBtn').html('Iniciar sesión');
                $('#loginBtn').prop('disabled', false);
            }
        });
    </script>
</body>
</html>
