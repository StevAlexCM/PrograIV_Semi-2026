const busqueda_matriculas = {
    data(){
        return{
            buscar:'',
            matriculas:[]
        }
    },
    methods:{
        modificarMatricula(matricula){
            this.$emit('modificar', matricula);
        },
        async obtenerMatriculas(){
            try {
                this.matriculas = await db.matriculas.filter(
                    matricula => (matricula.codigo_alumno || '').toLowerCase().includes(this.buscar.toLowerCase()) 
                        || (matricula.nombre_alumno || '').toLowerCase().includes(this.buscar.toLowerCase())
                ).toArray();
            } catch(e) {
                console.error(e);
                this.matriculas = [];
            }
            if( this.matriculas.length<1 && this.buscar.length<=0){
                fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/matriculas/matricula.php?accion=consultar`)
                    .then(response=>response.json())
                    .then(data=>{
                        this.matriculas = data;
                        db.matriculas.bulkPut(data);
                    });
            }
        },
        async eliminarMatricula(matricula, e){
            e.stopPropagation();
            alertify.confirm('Eliminar matriculas', `¿Está seguro de eliminar la matricula de ${matricula.nombre_alumno}?`, async e=>{
                await db.matriculas.delete(String(matricula.idMatricula));
                await db.matriculas.delete(Number(matricula.idMatricula));
                fetch(`http://localhost/PrograIV_Semi-2026/private/modulos/matriculas/matricula.php?accion=eliminar&matriculas=${encodeURIComponent(JSON.stringify(matricula))}`)
                    .then(response=>response.json())
                    .then(data=>{
                        if(data!=true) alertify.error(`Error al sincronizar con el servidor: ${data}`);
                    });
                this.obtenerMatriculas();
                alertify.success(`Matricula de ${matricula.nombre_alumno} eliminada correctamente`);
            }, () => {
                //No hacer nada
            });
        },
    },
    template: `
        <div class="row">
            <div class="col-8">
                <table class="table table-striped table-hover" id="tblMatriculas">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <input autocomplete="off" type="search" @keyup="obtenerMatriculas()" v-model="buscar" placeholder="Buscar matricula" class="form-control">
                            </th>
                        </tr>
                        <tr>
                            <th>COD ALUMNO</th>
                            <th>NOMBRE ALUMNO</th>
                            <th>FECHA</th>
                            <th>CICLO</th>
                            <th>ESTADO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="matricula in matriculas" :key="matricula.idMatricula" @click="modificarMatricula(matricula)">
                            <td>{{ matricula.codigo_alumno }}</td>
                            <td>{{ matricula.nombre_alumno }}</td>
                            <td>{{ matricula.fecha }}</td>
                            <td>{{ matricula.ciclo }}</td>
                            <td>{{ matricula.estado }}</td>
                            <td>
                                <button class="btn btn-danger" @click="eliminarMatricula(matricula, $event)">DEL</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `
};
