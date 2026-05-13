<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "Table: $tableName\n";
    $columns = Schema::getColumnListing($tableName);
    echo "Columns: " . implode(', ', $columns) . "\n\n";
}
