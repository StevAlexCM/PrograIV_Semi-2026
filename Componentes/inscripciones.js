const inscripciones = {
    props:['forms'],
    data(){
        return{
            inscripcion:{
                idInscripciones:0,
                codigo_alumno:"",
                nombre_alumno:"",
                codigo_materia:"",
                nombre_materia:"",
                uv:"",
                fecha_inscripcion:"",
                ciclo_periodo:"",
                estado:"",
                observaciones:""
            },
            accion:'nuevo',
            idInscripciones:0,
            data_inscripciones:[]
        }
    },
    methods:{
        buscarInscripcion(){
            this.forms.busqueda_inscripciones.mostrar = !this.forms.busqueda_inscripciones.mostrar;
            this.$emit('buscar');
        },
        modificarInscripcion(inscripcion){
            this.accion = 'modificar';
            this.idInscripciones = inscripcion.idInscripciones;
            this.inscripcion.codigo_alumno = inscripcion.codigo_alumno;
            this.inscripcion.nombre_alumno = inscripcion.nombre_alumno;
            this.inscripcion.codigo_materia = inscripcion.codigo_materia;
            this.inscripcion.nombre_materia = inscripcion.nombre_materia;
            this.inscripcion.uv = inscripcion.uv;
            this.inscripcion.fecha_inscripcion = inscripcion.fecha_inscripcion;
            this.inscripcion.ciclo_periodo = inscripcion.ciclo_periodo;
            this.inscripcion.estado = inscripcion.estado;
            this.inscripcion.observaciones = inscripcion.observaciones;
        },
        async guardarInscripcion() {
            let datos = {
                idInscripciones: this.accion=='modificar' ? this.idInscripciones : this.getId(),
                codigo_alumno: this.inscripcion.codigo_alumno,
                nombre_alumno: this.inscripcion.nombre_alumno,
                codigo_materia: this.inscripcion.codigo_materia,
                nombre_materia: this.inscripcion.nombre_materia,
                uv: this.inscripcion.uv,
                fecha_inscripcion: this.inscripcion.fecha_inscripcion,
                ciclo_periodo: this.inscripcion.ciclo_periodo,
                estado: this.inscripcion.estado,
                observaciones: this.inscripcion.observaciones
            };
            this.buscar = datos.codigo_alumno;

            db.inscripciones.put(datos);
            fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/inscripciones/inscripcion.php?accion=${this.accion}&inscripciones=${encodeURIComponent(JSON.stringify(datos))}`)
                .then(response=>response.json())
                .then(data=>{
                    if(data!=true) alertify.error(`Error al sincronizar con el servidor: ${data}`);
                });
            this.limpiarFormulario();
            alertify.success(`Inscripcion de ${datos.nombre_alumno} guardada correctamente`);
        },
        getId(){
            return new Date().getTime();
        },
        limpiarFormulario(){
            this.accion = 'nuevo';
            this.idInscripciones = 0;
            this.inscripcion.codigo_alumno = '';
            this.inscripcion.nombre_alumno = '';
            this.inscripcion.codigo_materia = '';
            this.inscripcion.nombre_materia = '';
            this.inscripcion.uv = '';
            this.inscripcion.fecha_inscripcion = '';
            this.inscripcion.ciclo_periodo = '';
            this.inscripcion.estado = '';
            this.inscripcion.observaciones = '';
        },
    },
    template: `
        <div class="row">
            <div class="col-8">
                <form id="frmInscripciones" @submit.prevent="guardarInscripcion" @reset.prevent="limpiarFormulario">
                    <div class="card text-bg-dark mb-3" style="max-width: 46rem;">
                        <div class="card-header">REGISTRO DE INSCRIPCIONES</div>
                        <div class="card-body">
                            <div class="row p-1">
                                <div class="col-3">CODIGO ALUMNO:</div>
                                <div class="col-3"><input placeholder="Codigo" required v-model="inscripcion.codigo_alumno" type="text" class="form-control"></div>
                                <div class="col-2">NOMBRE:</div>
                                <div class="col-4"><input placeholder="Nombre Alumno" required v-model="inscripcion.nombre_alumno" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3">CODIGO MATERIA:</div>
                                <div class="col-3"><input placeholder="Codigo Materia" required v-model="inscripcion.codigo_materia" type="text" class="form-control"></div>
                                <div class="col-2">MATERIA:</div>
                                <div class="col-4"><input placeholder="Nombre Materia" required v-model="inscripcion.nombre_materia" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3">UV:</div>
                                <div class="col-3"><input placeholder="UV" required v-model="inscripcion.uv" type="text" class="form-control"></div>
                                <div class="col-2">FECHA:</div>
                                <div class="col-4"><input placeholder="Fecha" required v-model="inscripcion.fecha_inscripcion" type="date" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3">CICLO/PERIODO:</div>
                                <div class="col-3"><input placeholder="Ciclo" required v-model="inscripcion.ciclo_periodo" type="text" class="form-control"></div>
                                <div class="col-2">ESTADO:</div>
                                <div class="col-4"><input placeholder="Estado" required v-model="inscripcion.estado" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3">OBSERVACIONES:</div>
                                <div class="col-9"><textarea placeholder="Observaciones" v-model="inscripcion.observaciones" class="form-control"></textarea></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" id="btnGuardarInscripcion" class="btn btn-primary">GUARDAR</button>
                                    <button type="reset" id="btnCancelarInscripcion" class="btn btn-warning">NUEVO</button>
                                    <button type="button" @click="buscarInscripcion" id="btnBuscarInscripcion" class="btn btn-success">BUSCAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `
};