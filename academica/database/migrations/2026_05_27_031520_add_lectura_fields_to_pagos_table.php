<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->decimal('lectura_anterior', 10, 2)->default(0.00);
            $table->decimal('lectura_actual', 10, 2)->default(0.00);
            $table->decimal('consumo', 10, 2)->default(0.00);
            $table->decimal('total_pagar', 10, 2)->default(0.00);
            $table->string('estado_pago', 20)->default('Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['lectura_anterior', 'lectura_actual', 'consumo', 'total_pagar', 'estado_pago']);
        });
    }
};
