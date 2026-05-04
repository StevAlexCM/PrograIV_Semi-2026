<?php
use Illuminate\Support\Facades\DB;
use App\Models\LoginUsuario;
use App\Models\LoginAdministrador;

DB::statement("ALTER TABLE login_usuario MODIFY COLUMN correo_usuario VARCHAR(100)");
DB::statement("ALTER TABLE login_usuario MODIFY COLUMN contraseña VARCHAR(100)");
DB::statement("ALTER TABLE login_administrador MODIFY COLUMN contraseña_admin VARCHAR(100)");

LoginUsuario::updateOrCreate(
    ['correo_usuario' => 'usuario@hidrovida.com'],
    ['contraseña' => '123456', 'is_active' => 1]
);

LoginAdministrador::updateOrCreate(
    ['correo_admin' => 'admin@hidrovida.com'],
    ['nombre_admin' => 'Admin Principal', 'contraseña_admin' => 'admin123']
);
