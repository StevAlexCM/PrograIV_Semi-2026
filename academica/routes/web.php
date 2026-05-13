<?php

use Illuminate\Support\Facades\Route;
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
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    $alerta_roja = App\Models\Alerta::where('tipo', 'red')->latest()->first();
    return view('welcome', compact('sensor', 'alerta_roja'));
});
Route::get('/calidad', function () {
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    return view('calidad', compact('sensor'));
});
Route::get('/alertas', function () {
    $alertas = App\Models\Alerta::latest()->get();
    return view('alertas', compact('alertas'));
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

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'correo_usuario' => 'required',
        'contraseña' => 'required'
    ]);

    // 1. Verificar si es un Administrador
    $admin = App\Models\LoginAdministrador::where('correo_admin', $credentials['correo_usuario'])
                                        ->where('contraseña_admin', $credentials['contraseña'])
                                        ->first();

    if ($admin) {
        session([
            'admin_id' => $admin->id_usuario,
            'usuario_nombre' => $admin->nombre_admin
        ]);
        return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/')]);
    }

    // 2. Si no es admin, verificar si es un Usuario
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

    return response()->json(['success' => false, 'message' => 'Número de cuenta o contraseña incorrectos.']);
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

// Admin Debug Sensores
Route::get('/admin/debug-sensores', function () {
    if (!session()->has('admin_id')) return redirect('/login_admin');
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    return view('admin.debug_sensores', compact('sensor'));
})->name('admin.sensores');

Route::post('/admin/debug-sensores', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return redirect('/login_admin');
    $request->validate([
        'ph_level' => 'required|numeric',
        'water_level' => 'required|integer'
    ]);
    
    $s = new App\Models\SensorReading();
    $s->ph_level = $request->ph_level;
    $s->water_level = $request->water_level;
    $s->save();
    
    return back()->with('success', 'Valores de los sensores simulados actualizados correctamente.');
});

Route::post('/admin/debug-sensores-api', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    
    $s = new App\Models\SensorReading();
    $s->ph_level = $request->ph_level;
    $s->water_level = $request->water_level;
    $s->save();
    
    return response()->json(['success' => true, 'message' => 'Sensores actualizados']);
});

// API de registro
Route::post('/api/registro', function (Illuminate\Http\Request $request) {
    try {
        $data = $request->validate([
            'nombre_completo' => 'required',
            'correo_usuario' => 'required|unique:login_usuario,correo_usuario',
            'sector_zona' => 'required',
            'contraseña' => 'required'
        ]);

        App\Models\LoginUsuario::create([
            'nombre_completo' => $data['nombre_completo'],
            'correo_usuario' => $data['correo_usuario'],
            'sector_zona' => $data['sector_zona'],
            'contraseña' => $data['contraseña'], // En un sistema real usaría Hash::make
            'is_active' => false, // Por seguridad empiezan inactivos
            'rol' => 'usuario'
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: Cuenta ya existe o datos inválidos.']);
    }
});

// Gestión de Usuarios (Admin)
Route::get('/admin/usuarios-api', function () {
    if (!session()->has('admin_id')) return response()->json([], 401);
    return App\Models\LoginUsuario::all();
});

Route::post('/admin/usuarios-rol-api', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return response()->json(['success' => false], 401);
    $u = App\Models\LoginUsuario::find($request->id_usuario);
    if ($u) {
        $u->rol = $request->rol;
        $u->is_active = $request->is_active;
        $u->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});

Route::get('/admin/alertas-api-list', function () {
    if (!session()->has('admin_id')) return response()->json([], 401);
    return App\Models\Alerta::latest()->get();
});

Route::get('/admin/reportes-api-list', function () {
    if (!session()->has('admin_id')) return response()->json([], 401);
    return DB::table('reportes_falla')->orderBy('created_at', 'desc')->get();
});

Route::delete('/admin/reportes-api/{id}', function ($id) {
    if (!session()->has('admin_id')) return response()->json(['success' => false], 401);
    DB::table('reportes_falla')->where('id_reporte', $id)->delete();
    return response()->json(['success' => true]);
});

Route::post('/admin/alertas-api', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    $a = new App\Models\Alerta();
    $a->fill($request->all());
    $a->save();
    return response()->json(['success' => true, 'message' => 'Alerta creada']);
});

Route::get('/admin/alertas-api', function () {
    if (!session()->has('admin_id')) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    return response()->json(App\Models\Alerta::latest()->get());
});

Route::delete('/admin/alertas-api/{id}', function ($id) {
    if (!session()->has('admin_id')) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    App\Models\Alerta::destroy($id);
    return response()->json(['success' => true, 'message' => 'Alerta eliminada']);
});

Route::get('/bienvenida/{nombre}', function ($nombre) {
    return '<h1>Bienvenido a mi pagina, hola '.$nombre.', como estas...</h1>';
});

// Limpieza de rutas académicas realizada.
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