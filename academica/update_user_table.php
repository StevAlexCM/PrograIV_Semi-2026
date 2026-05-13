<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Schema::table('login_usuario', function ($table) {
        if (!Schema::hasColumn('login_usuario', 'nombre_completo')) {
            $table->string('nombre_completo')->nullable()->after('id_usuario');
        }
        if (!Schema::hasColumn('login_usuario', 'sector_zona')) {
            $table->string('sector_zona')->nullable()->after('nombre_completo');
        }
        if (!Schema::hasColumn('login_usuario', 'rol')) {
            $table->string('rol')->default('usuario')->after('is_active');
        }
    });
    echo "Table login_usuario updated successfully.\n";

    // Transfer admin to login_usuario if not already there?
    // User wants "usuarios y ahi se pueda cambiar el rol" in the admin panel.
    // Let's just make sure we have some users to test with.
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
