<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAdministrador extends Model
{
    use HasFactory;

    protected $table = 'login_administrador';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = [
        'nombre_admin',
        'correo_admin',
        'contraseña_admin'
    ];

    protected $hidden = [
        'contraseña_admin',
    ];
}
