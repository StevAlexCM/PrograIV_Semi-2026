<?php
$_REQUEST['accion'] = 'nuevo';
$_REQUEST['alumnos'] = json_encode([
    'idAlumno' => 1710726858000,
    'codigo' => 'A03',
    'nombre' => 'Test PHP',
    'direccion' => 'Dir',
    'email' => 't@t.com',
    'telefono' => '1234',
    'hash' => ['words' => [1,2,3,4,5,6,7,8], 'sigBytes' => 32]
]);
require 'private/modulos/alumnos/alumno.php';
?>
