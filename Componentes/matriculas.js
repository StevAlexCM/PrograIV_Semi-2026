const matriculas = {
    props:['forms'],
    data(){
        return{
            matricula:{
                idMatricula:0,
                codigo_alumno:"",
                nombre_alumno:"",
                fecha:"",
                ciclo:"",
                estado:""
            },
            accion:'nuevo',
            idMatricula:0,
            data_matriculas:[]
        }
    },
    methods:{
        buscarMatricula(){
            this.forms.busqueda_matriculas.mostrar = !this.forms.busqueda_matriculas.mostrar;
            this.$emit('buscar');
        },
        modificarMatricula(matricula){
            this.accion = 'modificar';
            this.idMatricula = matricula.idMatricula;
            this.matricula.codigo_alumno = matricula.codigo_alumno;
            this.matricula.nombre_alumno = matricula.nombre_alumno;
            this.matricula.fecha = matricula.fecha;
            this.matricula.ciclo = matricula.ciclo;
            this.matricula.estado = matricula.estado;
        },
        async guardarMatricula() {
            let datos = {
                idMatricula: this.accion=='modificar' ? this.idMatricula : this.getId(),
                codigo_alumno: this.matricula.codigo_alumno,
                nombre_alumno: this.matricula.nombre_alumno,
                fecha: this.matricula.fecha,
                ciclo: this.matricula.ciclo,
                estado: this.matricula.estado
            };
            this.buscar = datos.codigo_alumno;

            db.matriculas.put(datos);
            fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/matriculas/matricula.php?accion=${this.accion}&matriculas=${encodeURIComponent(JSON.stringify(datos))}`)
                .then(response=>response.json())
                .then(data=>{
                    if(data!=true) alertify.error(`Error al sincronizar con el servidor: ${data}`);
                });
            this.limpiarFormulario();
            alertify.success(`Matricula de ${datos.nombre_alumno} guardada correctamente`);
        },
        getId(){
            return new Date().getTime();
        },
        limpiarFormulario(){
            this.accion = 'nuevo';
            this.idMatricula = 0;
            this.matricula.codigo_alumno = '';
            this.matricula.nombre_alumno = '';
            this.matricula.fecha = '';
            this.matricula.ciclo = '';
            this.matricula.estado = '';
        },
    },
    template: `
        <div class="row">
            <div class="col-6">
                <form id="frmMatriculas" @submit.prevent="guardarMatricula" @reset.prevent="limpiarFormulario">
                    <div class="card text-bg-dark mb-3" style="max-width: 36rem;">
                        <div class="card-header">REGISTRO DE MATRICULAS</div>
                        <div class="card-body">
                            <div class="row p-1">
                                <div class="col-4">CODIGO ALUMNO:</div>
                                <div class="col-8"><input placeholder="Codigo" required v-model="matricula.codigo_alumno" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-4">NOMBRE ALUMNO:</div>
                                <div class="col-8"><input placeholder="Nombre Alumno" required v-model="matricula.nombre_alumno" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-4">FECHA:</div>
                                <div class="col-8"><input placeholder="Fecha" required v-model="matricula.fecha" type="date" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-4">CICLO:</div>
                                <div class="col-8"><input placeholder="Ciclo" required v-model="matricula.ciclo" type="text" class="form-control"></div>
                            </div>
                            <div class="row p-1">
                                <div class="col-4">ESTADO:</div>
                                <div class="col-8"><input placeholder="Estado" required v-model="matricula.estado" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" id="btnGuardarMatricula" class="btn btn-primary">GUARDAR</button>
                                    <button type="reset" id="btnCancelarMatricula" class="btn btn-warning">NUEVO</button>
                                    <button type="button" @click="buscarMatricula" id="btnBuscarMatricula" class="btn btn-success">BUSCAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `
};
