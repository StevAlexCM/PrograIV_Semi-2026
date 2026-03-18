<?php
include(__DIR__ . '/../../Config/Config.php');
extract($_REQUEST);

$inscripciones = $inscripciones ?? '[]';
$accion = $accion ?? '';

$class_inscripciones = new inscripciones($conexion);
echo json_encode($class_inscripciones->recibir_datos($inscripciones));

class inscripciones{
    private $datos = [], $db, $respuesta=['msg'=>'ok'];

    public function __construct($conexion){
        $this->db = $conexion;
    }
    public function recibir_datos($inscripciones){
        global $accion;
        if($accion==='consultar'){
            return $this->administrar_inscripciones();
        }else{
            $this->datos = json_decode($inscripciones, true);
            return $this->validar_datos();
        }
    }
    private function validar_datos(){
        global $accion;
        if($accion === 'eliminar') {
            return $this->administrar_inscripciones();
        }
        if(empty($this->datos['codigo_alumno'])){
            $this->respuesta['msg'] = 'El codigo de alumno es requerido';
        }
        if(empty($this->datos['codigo_materia'])){
            $this->respuesta['msg'] = 'El codigo de materia es requerido';
        }
        return $this->administrar_inscripciones();
    }
    private function administrar_inscripciones(){
        global $accion;
        if($this->respuesta['msg']!=='ok'){
           return $this->respuesta;
        }
        if($accion==='nuevo'){
            return $this->db->consultaSQL('INSERT INTO inscripciones (idInscripciones, codigo_alumno, nombre_alumno, codigo_materia, nombre_materia, uv, fecha_inscripcion, ciclo_periodo, estado, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            $this->datos['idInscripciones'], $this->datos['codigo_alumno'], $this->datos['nombre_alumno'], $this->datos['codigo_materia'], $this->datos['nombre_materia'], $this->datos['uv'], $this->datos['fecha_inscripcion'], $this->datos['ciclo_periodo'], $this->datos['estado'], $this->datos['observaciones']);
        }else if($accion==='modificar'){
            return $this->db->consultaSQL('UPDATE inscripciones SET codigo_alumno = ?, nombre_alumno = ?, codigo_materia = ?, nombre_materia = ?, uv = ?, fecha_inscripcion = ?, ciclo_periodo = ?, estado = ?, observaciones = ? WHERE idInscripciones = ?',
            $this->datos['codigo_alumno'], $this->datos['nombre_alumno'], $this->datos['codigo_materia'], $this->datos['nombre_materia'], $this->datos['uv'], $this->datos['fecha_inscripcion'], $this->datos['ciclo_periodo'], $this->datos['estado'], $this->datos['observaciones'], $this->datos['idInscripciones']);
        }else if($accion==='eliminar'){
            return $this->db->consultaSQL('
                DELETE FROM inscripciones 
                WHERE idInscripciones = ?
            ',$this->datos['idInscripciones']);
        }else if($accion==='consultar'){
            $this->db->consultaSQL('
                SELECT idInscripciones, codigo_alumno, nombre_alumno, codigo_materia, nombre_materia, uv, fecha_inscripcion, ciclo_periodo, estado, observaciones 
                FROM inscripciones
            ');
            return $this->db->obtener_datos();
        }
    }
}
?>
