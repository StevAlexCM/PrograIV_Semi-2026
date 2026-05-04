<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - HidroVida</title>

     <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AlertifyJS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <a href="/" class="back-btn" title="Volver al inicio">
        <i class="bi bi-house-door-fill"></i>
    </a>

    <div class="login-container">
        <div class="login-box">
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="bi bi-droplet-half"></i>
                </div>
            </div>
            
            <h2 class="text-center">HidroVida</h2>
            <p class="text-center subtitle">Portal de la Comunidad</p>
            
            <form id="loginForm">
                @csrf
                <div class="mb-4">
                    <label for="correo_usuario" class="form-label">Correo / Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="correo_usuario" name="correo_usuario" placeholder="Ej. usuario@correo.com">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="••••••••">
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                    Iniciar Sesión <i class="bi bi-arrow-right-short ms-1"></i>
                </button>
            </form>

            <div class="text-center mt-4 contact-admin">
                <i class="bi bi-info-circle"></i> Solo el administrador puede crear nuevas cuentas.
            </div>

            <!-- Botón para admin -->
            <div class="text-center mt-3">
                <a href="/login_admin" class="admin-link">
                    <i class="bi bi-shield-lock-fill"></i> Soy administrador
                </a>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-dark: #1b3650;
            --accent-teal: #2cc0b3;
            --bg-overlay: rgba(27, 54, 80, 0.7);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #0f2027;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Si tienes la imagen fondo_login.jpg, la usará, sino usará el degradado oscuro */
            background: linear-gradient(to right bottom, rgba(15, 32, 39, 0.8), rgba(32, 58, 67, 0.8), rgba(44, 83, 100, 0.8)), url('{{ asset('img/fondo_login.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        .back-btn {
            position: absolute;
            top: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.3rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
            color: white;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 1rem;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-box {
            /* Efecto Glassmorphism Premium */
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2), inset 0 0 0 1px rgba(255,255,255,0.5);
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .logo-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--accent-teal), #1a8b80);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.2rem;
            box-shadow: 0 8px 20px rgba(44, 192, 179, 0.4);
        }

        h2 {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 0.2rem;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: transparent;
            border: 2px solid #e2e8f0;
            border-right: none;
            color: #94a3b8;
            font-size: 1.2rem;
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-left: none;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-dark);
            border-radius: 0 12px 12px 0;
            background-color: transparent;
        }

        .input-group:focus-within .input-group-text,
        .form-control:focus {
            border-color: var(--accent-teal);
            box-shadow: none;
            color: var(--primary-dark);
        }
        
        .toggle-password {
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            background: transparent;
            color: #94a3b8;
        }
        .toggle-password:hover {
            background: #f1f5f9;
            color: var(--primary-dark);
        }
        .input-group:focus-within .toggle-password {
            border-color: var(--accent-teal);
        }

        /* Fix radius for input when there is a toggle button */
        #contraseña {
            border-radius: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-dark), #102436);
            border: none;
            color: white;
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 8px 15px rgba(27, 54, 80, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(27, 54, 80, 0.3);
            background: linear-gradient(135deg, #102436, #091520);
        }

        .contact-admin {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            background: #f8fafc;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px dashed #cbd5e0;
        }

        .admin-link {
            color: var(--primary-dark);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            opacity: 0.8;
        }
        .admin-link:hover {
            color: var(--accent-teal);
            opacity: 1;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <script>
        $(document).ready(function() {
            // Configurar alertify
            alertify.defaults = {
                notifier: {
                    delay: 4000,
                    position: 'top-right',
                    closeButton: true
                },
                theme: {
                    okBtn: 'btn btn-primary',
                    cancelBtn: 'btn btn-secondary'
                }
            };

            // Toggle Password Visibility
            $('.toggle-password').on('click', function() {
                const passwordField = $('#contraseña');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
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
                        $('#loginBtn').html('<span class="spinner-border spinner-border-sm me-2"></span>Ingresando...');
                        $('#loginBtn').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success(response.message);
                            setTimeout(function() {
                                window.location.href = response.url;
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
                $('#loginBtn').html('Iniciar Sesión <i class="bi bi-arrow-right-short ms-1"></i>');
                $('#loginBtn').prop('disabled', false);
            }
        });
    </script>
</body>
</html>
