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
        'Informacion_de_contacto',
        'categoria_de_problema',
        'descripcion',
        'numero_casa',
        'sector_manzana_calle'
    ];
}
