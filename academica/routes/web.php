<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/calidad', function () {
    return view('calidad');
});
Route::get('/alertas', function () {
    return view('alertas');
});
Route::get('/reportar', function () {
    return view('reportar');
});
Route::get('/estandares', function () {
    return view('estandares');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'correo_usuario' => 'required',
        'contraseña' => 'required'
    ]);

    // Búsqueda manual porque usamos una tabla personalizada
    $usuario = App\Models\LoginUsuario::where('correo_usuario', $credentials['correo_usuario'])
                                        ->where('contraseña', $credentials['contraseña'])
                                        ->first();

    if ($usuario) {
        if ($usuario->is_active) {
            // Guardamos sesión simple
            session([
                'usuario_id' => $usuario->id_usuario,
                'usuario_nombre' => explode('@', $usuario->correo_usuario)[0]
            ]);
            return response()->json(['success' => true, 'message' => '¡Bienvenido a HidroVida!', 'url' => url('/')]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tu cuenta está inactiva. Contacta al administrador.']);
        }
    }

    return response()->json(['success' => false, 'message' => 'Correo o contraseña incorrectos.']);
});

// Rutas para Login Administrador
Route::get('/login_admin', function () {
    return view('login_admin');
})->name('login.admin.view');

Route::post('/login_admin', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'correo_admin' => 'required',
        'contraseña_admin' => 'required'
    ]);

    $admin = App\Models\LoginAdministrador::where('correo_admin', $credentials['correo_admin'])
                                        ->where('contraseña_admin', $credentials['contraseña_admin'])
                                        ->first();

    if ($admin) {
        session([
            'admin_id' => $admin->id_usuario,
            'usuario_nombre' => $admin->nombre_admin
        ]);
        // Podrías redirigir a un dashboard específico de admin después
        return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/')]);
    }

    return response()->json(['success' => false, 'message' => 'Credenciales administrativas incorrectas.']);
})->name('login.admin');

Route::get('/logout', function () {
    session()->forget(['usuario_id', 'admin_id', 'usuario_nombre']);
    return redirect('/');
});

Route::get('/bienvenida/{nombre}', function ($nombre) {
    return '<h1>Bienvenido a mi pagina, hola '.$nombre.', como estas...</h1>';
});

Route::controller(AlumnoController::class)->group(function () {
    Route::get('/alumno', 'index');
    Route::post('/alumno', 'store');
    Route::put('/alumno', 'update');
    Route::delete('/alumno', 'destroy');
});
Route::controller(DocenteController::class)->group(function () {
    Route::get('/docente', 'index');
    Route::post('/docente', 'store');
    Route::put('/docente', 'update');
    Route::delete('/docente', 'destroy');
});
Route::controller(MateriaController::class)->group(function () {
    Route::get('/materia', 'index');
    Route::post('/materia', 'store');
    Route::put('/materia', 'update');
    Route::delete('/materia', 'destroy');
});
Route::controller(MatriculaController::class)->group(function () {
    Route::get('/matricula', 'index');
    Route::post('/matricula', 'store');
    Route::put('/matricula', 'update');
    Route::delete('/matricula', 'destroy');
});
Route::controller(InscripcionController::class)->group(function () {
    Route::get('/inscripcion', 'index');
    Route::post('/inscripcion', 'store');
    Route::put('/inscripcion', 'update');
    Route::delete('/inscripcion', 'destroy');
});
Route::controller(PagoController::class)->group(function () {
    Route::get('/pago', 'index');
    Route::post('/pago', 'store');
    Route::put('/pago', 'update');
    Route::delete('/pago', 'destroy');
});
Route::controller(ReporteController::class)->group(function () {
    Route::get('/reporte', 'index');
    Route::post('/reporte', 'store');
    Route::put('/reporte', 'update');
    Route::delete('/reporte', 'destroy');
});