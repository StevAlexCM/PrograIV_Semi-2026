<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - HidroVida</title>

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
    <a href="/login" class="back-btn" title="Volver al Login Normal">
        <i class="bi bi-arrow-left"></i>
    </a>

    <div class="login-container">
        <div class="login-box">
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
            </div>
            
            <h2 class="text-center">HidroVida</h2>
            <p class="text-center subtitle">Panel de Administración</p>
            
            <form id="loginAdminForm">
                @csrf
                <div class="mb-4">
                    <label for="correo_admin" class="form-label">Correo Administrativo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="text" class="form-control" id="correo_admin" name="correo_admin" placeholder="Ej. admin@hidrovida.com">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="contraseña_admin" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="password" class="form-control" id="contraseña_admin" name="contraseña_admin" placeholder="••••••••">
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-admin w-100" id="loginAdminBtn">
                    Ingresar al Panel <i class="bi bi-shield-check ms-1"></i>
                </button>
            </form>
        </div>
    </div>

    <style>
        :root {
            --admin-dark: #1e293b;
            --admin-accent: #f59e0b; /* Amber */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            position: relative;
        }

        .back-btn {
            position: absolute;
            top: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.3rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.15);
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
            /* Efecto Dark Glassmorphism */
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .logo-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--admin-accent), #d97706);
            border-radius: 20%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.2rem;
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
            transform: rotate(45deg);
        }
        .logo-circle i {
            transform: rotate(-45deg);
        }

        h2 {
            color: white;
            font-weight: 800;
            margin-bottom: 0.2rem;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: var(--admin-accent);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #cbd5e0;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255,255,255,0.1);
            border-right: none;
            color: #64748b;
            font-size: 1.2rem;
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            border: 1px solid rgba(255,255,255,0.1);
            border-left: none;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            font-weight: 500;
            color: white;
            border-radius: 0 12px 12px 0;
            background-color: rgba(15, 23, 42, 0.5);
        }
        .form-control::placeholder {
            color: #475569;
        }

        .input-group:focus-within .input-group-text,
        .form-control:focus {
            border-color: var(--admin-accent);
            box-shadow: none;
            color: white;
            background-color: rgba(15, 23, 42, 0.8);
        }
        .input-group:focus-within .input-group-text {
            color: var(--admin-accent);
        }
        
        .toggle-password {
            border: 1px solid rgba(255,255,255,0.1);
            border-left: none;
            border-radius: 0 12px 12px 0;
            background: rgba(15, 23, 42, 0.5);
            color: #64748b;
        }
        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .input-group:focus-within .toggle-password {
            border-color: var(--admin-accent);
            background-color: rgba(15, 23, 42, 0.8);
        }

        #contraseña_admin {
            border-radius: 0;
        }

        .btn-admin {
            background: linear-gradient(135deg, var(--admin-accent), #d97706);
            border: none;
            color: white;
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 8px 15px rgba(245, 158, 11, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(245, 158, 11, 0.3);
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
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
            alertify.defaults = {
                notifier: { delay: 4000, position: 'top-right', closeButton: true },
                theme: { okBtn: 'btn btn-primary', cancelBtn: 'btn btn-secondary' }
            };

            // Toggle Password Visibility
            $('.toggle-password').on('click', function() {
                const passwordField = $('#contraseña_admin');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
                }
            });

            // Admin Login Request
            $('#loginAdminForm').on('submit', function(e) {
                e.preventDefault(); 

                const correo_admin = $('#correo_admin').val().trim();
                const contraseña_admin = $('#contraseña_admin').val();
                const token = $('meta[name="csrf-token"]').attr('content');

                if (!correo_admin || !contraseña_admin) {
                    alertify.error('Complete las credenciales administrativas');
                    return;
                }

                $.ajax({
                    url: '{{ route("login.admin") }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        correo_admin: correo_admin,
                        contraseña_admin: contraseña_admin
                    },
                    beforeSend: function() {
                        $('#loginAdminBtn').html('<span class="spinner-border spinner-border-sm me-2"></span>Verificando...');
                        $('#loginAdminBtn').prop('disabled', true);
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
                $('#loginAdminBtn').html('Ingresar al Panel <i class="bi bi-shield-check ms-1"></i>');
                $('#loginAdminBtn').prop('disabled', false);
            }
        });
    </script>
</body>
</html>
