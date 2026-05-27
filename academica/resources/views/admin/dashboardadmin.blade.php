@extends('layouts.public')

@section('title', 'Panel de Administración - HidroVida')

@section('content')
<div class="container-fluid">
    <!-- Custom Vue Admin Dashboard Component -->
    <admin-dashboard admin-name="{{ session('usuario_nombre', 'Administrador') }}"></admin-dashboard>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
