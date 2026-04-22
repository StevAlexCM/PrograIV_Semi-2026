<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes_falla';
    protected $primaryKey = 'id_reporte';
    protected $fillable = [
        'id_usuario',
        'fecha_reporte',
        'tipo_falla',
        'descripcion',
        'direccion',
        'zona'
    ];
}
