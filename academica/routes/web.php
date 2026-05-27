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
    
    // Fetch highest priority alert (using proximity escalation logic)
    $alerta_prioritaria = App\Models\Alerta::all()->map(function ($alerta) {
        try {
            if ($alerta->tipo !== 'blue' && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $alerta->fecha_texto)) {
                $targetDate = \Carbon\Carbon::parse($alerta->fecha_texto);
                $now = \Carbon\Carbon::now();
                $diffInHours = $now->diffInHours($targetDate, false);
                if ($diffInHours <= 48) {
                    $alerta->tipo = 'red';
                }
            }
        } catch (\Exception $e) {}
        return $alerta;
    })->sort(function ($a, $b) {
        $rank = ['red' => 1, 'yellow' => 2, 'blue' => 3];
        $rankA = $rank[$a->tipo] ?? 4;
        $rankB = $rank[$b->tipo] ?? 4;
        if ($rankA === $rankB) {
            return $b->created_at <=> $a->created_at;
        }
        return $rankA <=> $rankB;
    })->first();

    // Fetch the logged-in user's latest payment receipt
    $ultimo_recibo = null;
    if (session()->has('usuario_id')) {
        $ultimo_recibo = App\Models\Pago::where('id_usuario', session('usuario_id'))
                                         ->orderBy('created_at', 'desc')
                                         ->first();
    }

    // Recent alerts feed
    $alertas_recientes = App\Models\Alerta::latest()->take(3)->get();

    return view('welcome', compact('sensor', 'alerta_prioritaria', 'ultimo_recibo', 'alertas_recientes'));
});
Route::get('/calidad', function () {
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    return view('calidad', compact('sensor'));
});
Route::get('/alertas', function () {
    $alertas = App\Models\Alerta::all()->map(function ($alerta) {
        try {
            if ($alerta->tipo !== 'blue' && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $alerta->fecha_texto)) {
                $targetDate = \Carbon\Carbon::parse($alerta->fecha_texto);
                $now = \Carbon\Carbon::now();
                $diffInHours = $now->diffInHours($targetDate, false);
                if ($diffInHours <= 48) {
                    $alerta->tipo = 'red';
                }
            }
        } catch (\Exception $e) {}
        return $alerta;
    })->sort(function ($a, $b) {
        $rank = ['red' => 1, 'yellow' => 2, 'blue' => 3];
        $rankA = $rank[$a->tipo] ?? 4;
        $rankB = $rank[$b->tipo] ?? 4;
        if ($rankA === $rankB) {
            return $b->created_at <=> $a->created_at;
        }
        return $rankA <=> $rankB;
    })->values();

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
        return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/admin/dashboard')]);
    }

    // 2. Si no es admin, verificar si es un Usuario
    $usuario = App\Models\LoginUsuario::where('correo_usuario', $credentials['correo_usuario'])
                                        ->where('contraseña', $credentials['contraseña'])
                                        ->first();

    if ($usuario) {
        if ($usuario->is_active) {
            session([
                'usuario_id' => $usuario->id_usuario,
                'usuario_nombre' => $usuario->nombre_completo ?? explode('@', $usuario->correo_usuario)[0]
            ]);

            // Si el rol es admin, también asignarle permisos de administrador en sesión
            if ($usuario->rol === 'admin') {
                session([
                    'admin_id' => $usuario->id_usuario
                ]);
                return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/admin/dashboard')]);
            }

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
        return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/admin/dashboard')]);
    }

    // Permitir ingresar si es de la tabla LoginUsuario con rol 'admin'
    $usuario = App\Models\LoginUsuario::where('correo_usuario', $credentials['correo_admin'])
                                        ->where('contraseña', $credentials['contraseña_admin'])
                                        ->where('rol', 'admin')
                                        ->first();

    if ($usuario) {
        if ($usuario->is_active) {
            session([
                'usuario_id' => $usuario->id_usuario,
                'admin_id' => $usuario->id_usuario,
                'usuario_nombre' => $usuario->nombre_completo ?? explode('@', $usuario->correo_usuario)[0]
            ]);
            return response()->json(['success' => true, 'message' => '¡Bienvenido Administrador!', 'url' => url('/admin/dashboard')]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tu cuenta está inactiva. Contacta al administrador.']);
        }
    }

    return response()->json(['success' => false, 'message' => 'Credenciales administrativas incorrectas.']);
})->name('login.admin');

Route::get('/logout', function () {
    session()->forget(['usuario_id', 'admin_id', 'usuario_nombre']);
    return redirect('/');
});

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    if (!session()->has('admin_id')) return redirect('/login_admin');
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    return view('admin.dashboardadmin', compact('sensor'));
})->name('admin.dashboard');

Route::get('/admin/sensor-api', function () {
    if (!session()->has('admin_id')) return response()->json(['error' => 'Unauthorized'], 401);
    $sensor = App\Models\SensorReading::latest()->first() ?? new App\Models\SensorReading(['ph_level' => 7.2, 'water_level' => 75]);
    $history = App\Models\SensorReading::latest()->take(15)->get()->reverse()->values();
    return response()->json([
        'sensor' => $sensor,
        'history' => $history
    ]);
});

Route::get('/admin/actividades-api', function () {
    if (!session()->has('admin_id')) return response()->json(['error' => 'Unauthorized'], 401);
    
    $users = App\Models\LoginUsuario::latest()->take(5)->get();
    $alerts = App\Models\Alerta::latest()->take(5)->get();
    $sensors = App\Models\SensorReading::latest()->take(5)->get();
    $reports = DB::table('reportes_falla')->orderBy('created_at', 'desc')->take(5)->get();
    $payments = App\Models\Pago::latest()->take(5)->get();
    
    $activities = collect();
    
    foreach ($users as $user) {
        $activities->push([
            'titulo' => 'Usuario nuevo registrado',
            'descripcion' => ($user->nombre_completo ?? 'Usuario') . ' (' . $user->correo_usuario . ')',
            'tiempo' => $user->created_at ? $user->created_at->diffForHumans() : 'Recientemente',
            'created_at' => $user->created_at ? $user->created_at->toIso8601String() : now()->toIso8601String(),
            'icon' => 'bi-person-plus-fill',
            'color' => 'text-primary bg-primary-subtle border-primary-subtle'
        ]);
    }
    
    foreach ($alerts as $alert) {
        $activities->push([
            'titulo' => 'Nueva alerta publicada',
            'descripcion' => $alert->titulo . ' (' . $alert->zona . ')',
            'tiempo' => $alert->created_at ? $alert->created_at->diffForHumans() : 'Recientemente',
            'created_at' => $alert->created_at ? $alert->created_at->toIso8601String() : now()->toIso8601String(),
            'icon' => 'bi-megaphone-fill',
            'color' => 'text-danger bg-danger-subtle border-danger-subtle'
        ]);
    }
    
    foreach ($sensors as $sensor) {
        $activities->push([
            'titulo' => 'Lectura de sensores simulada',
            'descripcion' => 'pH: ' . $sensor->ph_level . ' · Tanque: ' . $sensor->water_level . '%',
            'tiempo' => $sensor->created_at ? $sensor->created_at->diffForHumans() : 'Recientemente',
            'created_at' => $sensor->created_at ? $sensor->created_at->toIso8601String() : now()->toIso8601String(),
            'icon' => 'bi-sliders',
            'color' => 'text-success bg-success-subtle border-success-subtle'
        ]);
    }
    
    foreach ($reports as $report) {
        $createdAt = Carbon\Carbon::parse($report->created_at);
        $activities->push([
            'titulo' => 'Reporte de falla recibido',
            'descripcion' => $report->descripcion . ' (' . $report->sector_manzana_calle . ')',
            'tiempo' => $createdAt->diffForHumans(),
            'created_at' => $createdAt->toIso8601String(),
            'icon' => 'bi-file-earmark-text-fill',
            'color' => 'text-info bg-info-subtle border-info-subtle'
        ]);
    }

    foreach ($payments as $payment) {
        $activities->push([
            'titulo' => 'Recibo de pago generado',
            'descripcion' => 'Cuenta: #' . $payment->id_usuario . ' · Periodo: ' . $payment->mes_facturado . ' · Total: $' . number_format($payment->total_pagar, 2),
            'tiempo' => $payment->created_at ? $payment->created_at->diffForHumans() : 'Recientemente',
            'created_at' => $payment->created_at ? $payment->created_at->toIso8601String() : now()->toIso8601String(),
            'icon' => 'bi-receipt-cutoff',
            'color' => 'text-warning bg-warning-subtle border-warning-subtle'
        ]);
    }
    
    $sortedActivities = $activities->sortByDesc('created_at')->values()->take(10);
    
    return response()->json($sortedActivities);
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
    $alertas = App\Models\Alerta::all()->map(function ($alerta) {
        try {
            if ($alerta->tipo !== 'blue' && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $alerta->fecha_texto)) {
                $targetDate = \Carbon\Carbon::parse($alerta->fecha_texto);
                $now = \Carbon\Carbon::now();
                $diffInHours = $now->diffInHours($targetDate, false);
                if ($diffInHours <= 48) {
                    $alerta->tipo = 'red';
                }
            }
        } catch (\Exception $e) {}
        return $alerta;
    })->sort(function ($a, $b) {
        $rank = ['red' => 1, 'yellow' => 2, 'blue' => 3];
        $rankA = $rank[$a->tipo] ?? 4;
        $rankB = $rank[$b->tipo] ?? 4;
        if ($rankA === $rankB) {
            return $b->created_at <=> $a->created_at;
        }
        return $rankA <=> $rankB;
    })->values();
    return response()->json($alertas);
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

// Admin Billing endpoints
Route::get('/admin/pagos/ultimo-registro/{id_usuario}', function ($id_usuario) {
    if (!session()->has('admin_id')) return response()->json(['lectura_actual' => 0.00], 401);
    $ultimo = App\Models\Pago::where('id_usuario', $id_usuario)
                             ->orderBy('created_at', 'desc')
                             ->orderBy('id_pago', 'desc')
                             ->first();
    return response()->json([
        'lectura_actual' => $ultimo ? (float)$ultimo->lectura_actual : 0.00
    ]);
});

Route::get('/admin/pagos-api-list', function () {
    if (!session()->has('admin_id')) return response()->json([], 401);
    return App\Models\Pago::orderBy('created_at', 'desc')->get();
});

Route::post('/admin/pagos-api', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    $request->validate([
        'id_usuario' => 'required|integer',
        'fecha_pago' => 'required',
        'mes_facturado' => 'required|string',
        'lectura_anterior' => 'required|numeric',
        'lectura_actual' => 'required|numeric',
        'consumo' => 'required|numeric',
        'total_pagar' => 'required|numeric',
    ]);
    $p = App\Models\Pago::create($request->all());
    return response()->json(['success' => true, 'message' => 'Recibo generado correctamente', 'data' => $p]);
});

Route::post('/admin/pagos-api/cambiar-estado', function (Illuminate\Http\Request $request) {
    if (!session()->has('admin_id')) return response()->json(['success' => false], 401);
    $p = App\Models\Pago::find($request->id_pago);
    if ($p) {
        $p->estado_pago = $request->estado_pago;
        $p->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});

Route::delete('/admin/pagos-api/{id}', function ($id) {
    if (!session()->has('admin_id')) return response()->json(['success' => false], 401);
    App\Models\Pago::destroy($id);
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
    $alertas = App\Models\Alerta::all()->map(function ($alerta) {
        try {
            if ($alerta->tipo !== 'blue' && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $alerta->fecha_texto)) {
                $targetDate = \Carbon\Carbon::parse($alerta->fecha_texto);
                $now = \Carbon\Carbon::now();
                $diffInHours = $now->diffInHours($targetDate, false);
                if ($diffInHours <= 48) {
                    $alerta->tipo = 'red';
                }
            }
        } catch (\Exception $e) {}
        return $alerta;
    })->sort(function ($a, $b) {
        $rank = ['red' => 1, 'yellow' => 2, 'blue' => 3];
        $rankA = $rank[$a->tipo] ?? 4;
        $rankB = $rank[$b->tipo] ?? 4;
        if ($rankA === $rankB) {
            return $b->created_at <=> $a->created_at;
        }
        return $rankA <=> $rankB;
    })->values();
    return response()->json($alertas);
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