<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>::. Formulario de Pagos y Reporte de HidroVida ..::</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
       <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <style>
            body {
                background-color: #f0f4f8;
                font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            }
            .navbar-brand {
                font-weight: 700;
                letter-spacing: 0.5px;
            }
            .component-wrapper {
                margin: 2rem;
                display: inline-block;
                z-index: 10;
            }
            .nav-link {
                font-weight: 500;
                transition: color 0.3s ease;
            }
            .nav-link:hover {
                color: #e0f2fe !important;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="appSistema">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="#"><i class="bi bi-droplet-half me-2"></i>HIDROVIDA</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                        <div class="navbar-nav mx-auto gap-3">
                            <a class="nav-link text-white" href="#" @click.prevent="abrirVentana('pagos')"><i class="bi bi-wallet2 me-1"></i> Pagos</a>
                            <a class="nav-link text-white" href="#" @click.prevent="abrirVentana('reportes')"><i class="bi bi-exclamation-triangle me-1"></i> Reportes</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="container-fluid d-flex flex-wrap align-items-start justify-content-center" style="position: relative; min-height: 80vh; padding-top: 2rem;">
                <pagos @buscar='buscar("buscar_pagos","obtenerPagos")' :forms="forms" ref="pagos" v-show="forms.pagos.mostrar"></pagos>
                <buscar_pagos @modificar='modificar("pagos","modificarPago", $event)' :forms="forms" ref="buscar_pagos" v-show="forms.buscar_pagos.mostrar"></buscar_pagos>

                <reportes @buscar='buscar("buscar_reportes","obtenerReportes")' :forms="forms" ref="reportes" v-show="forms.reportes.mostrar"></reportes>
                <buscar_reportes @modificar='modificar("reportes","modificarReporte", $event)' :forms="forms" ref="buscar_reportes" v-show="forms.buscar_reportes.mostrar"></buscar_reportes>
            </div>
        </div>

        @vite('resources/js/app.js')
    </body>
</html>