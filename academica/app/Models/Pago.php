<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pago';
    protected $fillable = [
        'id_usuario', 
        'fecha_pago', 
        'mes_facturado', 
        'lectura_anterior', 
        'lectura_actual', 
        'consumo', 
        'total_pagar',
        'estado_pago'
    ];
}
