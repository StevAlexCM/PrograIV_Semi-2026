<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginUsuario extends Model
{
    use HasFactory;

    protected $table = 'login_usuario';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = [
        'nombre_completo',
        'correo_usuario',
        'sector_zona',
        'contraseña',
        'is_active',
        'rol'
    ];

    protected $hidden = [
        'contraseña',
    ];
}
