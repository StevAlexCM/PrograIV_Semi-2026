<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = ['tipo', 'titulo', 'fecha_texto', 'zona', 'motivo', 'descripcion'];
}
