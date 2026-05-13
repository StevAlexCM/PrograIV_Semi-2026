<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    App\Models\Reporte::create([
        'id_usuario' => null,
        'Informacion_de_contacto' => 'Test',
        'categoria_de_problema' => 'agua_sucia',
        'descripcion' => 'Test desc',
        'numero_casa' => '123',
        'sector_manzana_calle' => 'Sector A'
    ]);
    echo "OK\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
