const busqueda_inscripciones = {
    data(){
        return{
            buscar:'',
            inscripciones:[]
        }
    },
    methods:{
        modificarInscripcion(inscripcion){
            this.$emit('modificar', inscripcion);
        },
        async obtenerInscripciones(){
            try {
                this.inscripciones = await db.inscripciones.filter(
                    inscripcion => (inscripcion.codigo_alumno || '').toLowerCase().includes(this.buscar.toLowerCase()) 
                        || (inscripcion.nombre_alumno || '').toLowerCase().includes(this.buscar.toLowerCase())
                        || (inscripcion.nombre_materia || '').toLowerCase().includes(this.buscar.toLowerCase())
                ).toArray();
            } catch(e) {
                console.error(e);
                this.inscripciones = [];
            }
            if( this.inscripciones.length<1 && this.buscar.length<=0){
                fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/inscripciones/inscripcion.php?accion=consultar`)
                    .then(response=>response.json())
                    .then(data=>{
                        this.inscripciones = data;
                        db.inscripciones.bulkPut(data);
                    });
            }
        },
        async eliminarInscripcion(inscripcion, e){
            e.stopPropagation();
            alertify.confirm('Eliminar inscripciones', `¿Está seguro de eliminar la inscripcion de ${inscripcion.nombre_alumno}?`, async e=>{
                await db.inscripciones.delete(String(inscripcion.idInscripciones));
                await db.inscripciones.delete(Number(inscripcion.idInscripciones));
                fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/inscripciones/inscripcion.php?accion=eliminar&inscripciones=${encodeURIComponent(JSON.stringify(inscripcion))}`)
                    .then(response=>response.json())
                    .then(data=>{
                        if(data!=true) alertify.error(`Error al sincronizar con el servidor: ${data}`);
                    });
                this.obtenerInscripciones();
                alertify.success(`Inscripcion de ${inscripcion.nombre_alumno} eliminada correctamente`);
            }, () => {
                //No hacer nada
            });
        },
    },
    template: `
        <div class="row">
            <div class="col-8">
                <table class="table table-striped table-hover" id="tblInscripciones">
                    <thead>
                        <tr>
                            <th colspan="9">
                                <input autocomplete="off" type="search" @keyup="obtenerInscripciones()" v-model="buscar" placeholder="Buscar inscripcion" class="form-control">
                            </th>
                        </tr>
                        <tr>
                            <th>COD ALUMNO</th>
                            <th>NOMBRE ALUMNO</th>
                            <th>MATERIA</th>
                            <th>UV</th>
                            <th>FECHA</th>
                            <th>CICLO</th>
                            <th>ESTADO</th>
                            <th>OBSERVACIONES</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inscripcion in inscripciones" :key="inscripcion.idInscripciones" @click="modificarInscripcion(inscripcion)">
                            <td>{{ inscripcion.codigo_alumno }}</td>
                            <td>{{ inscripcion.nombre_alumno }}</td>
                            <td>{{ inscripcion.nombre_materia }}</td>
                            <td>{{ inscripcion.uv }}</td>
                            <td>{{ inscripcion.fecha_inscripcion }}</td>
                            <td>{{ inscripcion.ciclo_periodo }}</td>
                            <td>{{ inscripcion.estado }}</td>
                            <td>{{ inscripcion.observaciones }}</td>
                            <td>
                                <button class="btn btn-danger" @click="eliminarInscripcion(inscripcion, $event)">DEL</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `
};
