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
        'correo_usuario',
        'contraseña',
        'is_active'
    ];

    // Para evitar que la contraseña se muestre en consultas (opcional)
    protected $hidden = [
        'contraseña',
    ];
}
