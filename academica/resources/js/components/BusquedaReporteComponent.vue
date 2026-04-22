<template>
    <div v-draggable class="component-wrapper">
         <div class="card shadow-lg border-0 rounded-4" style="width: 850px;">
             <div class="card-header bg-danger bg-gradient text-white py-3 border-0 rounded-top-4">
                 <div class="d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-semibold"><i class="bi bi-search me-2"></i>Búsqueda de Reportes</h5>
                     <button type="button" class="btn-close btn-close-white" aria-label="Close" @click="cerrarFormularioBusquedaReportes"></button>
                 </div>
             </div>
             <div class="card-body p-4 bg-white rounded-bottom-4">
                 <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden">
                     <span class="input-group-text bg-light border-0 px-3"><i class="bi bi-search text-muted"></i></span>
                     <input autocomplete="off" type="search" @keyup="obtenerReportes()" v-model="buscar" placeholder="Buscar en cualquier campo..." class="form-control border-0 bg-light shadow-none py-2">
                 </div>
                 
                 <div class="table-responsive">
                     <table class="table table-hover align-middle mb-0" id="tblReportes">
                         <thead class="table-light">
                             <tr>
                                 <th class="border-0 rounded-start text-secondary fw-semibold">ID USUARIO</th>
                                 <th class="border-0 text-secondary fw-semibold">FECHA</th>
                                 <th class="border-0 text-secondary fw-semibold">TIPO FALLA</th>
                                 <th class="border-0 text-secondary fw-semibold">DESCRIPCIÓN</th>
                                 <th class="border-0 text-secondary fw-semibold">DIRECCIÓN</th>
                                 <th class="border-0 text-secondary fw-semibold">ZONA</th>
                                 <th class="border-0 rounded-end text-center text-secondary fw-semibold">ACCIÓN</th>
                             </tr>
                         </thead>
                         <tbody class="border-top-0">
                             <tr v-for="reporte in reportes" :key="reporte.id_reporte" @click="modificarReporte(reporte)" style="cursor: pointer; transition: all 0.2s;">
                                 <td class="text-dark fw-medium">{{ reporte.id_usuario }}</td>
                                 <td class="text-secondary small">{{ reporte.fecha_reporte }}</td>
                                 <td><span class="badge bg-warning bg-opacity-25 text-danger border border-warning-subtle rounded-pill px-3 py-2">{{ reporte.tipo_falla }}</span></td>
                                 <td class="text-secondary text-truncate" style="max-width: 150px;" :title="reporte.descripcion">{{ reporte.descripcion }}</td>
                                 <td class="text-secondary text-truncate" style="max-width: 120px;" :title="reporte.direccion">{{ reporte.direccion }}</td>
                                 <td class="text-secondary"><span class="badge bg-light text-dark border">{{ reporte.zona }}</span></td>
                                 <td class="text-center">
                                     <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" @click.stop="eliminarReporte(reporte)" title="Eliminar">
                                         <i class="bi bi-trash"></i>
                                     </button>
                                 </td>
                             </tr>
                             <tr v-if="reportes.length === 0">
                                 <td colspan="7" class="text-center text-muted py-5"><i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>No se encontraron reportes.</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import alertify from 'alertifyjs';

    export default{
        props:['forms'],
        data(){
            return{
                reportes:[],
                buscar:''
            }
        },
        methods:{
            cerrarFormularioBusquedaReportes(){
                this.forms.buscar_reportes.mostrar = false;
            },
            modificarReporte(reporte){
                this.$emit('modificar', reporte);
            },
            eliminarReporte(reporte){
                alertify.confirm('¿Está seguro de eliminar este reporte?', async ()=>{ 
                    axios({
                        method:'DELETE',
                        url:'reporte',
                        data:reporte,
                        headers:{
                            'Content-Type':'application/json',
                            'Accept':'application/json'
                        }
                    }).then(response=>{
                        if(response.data && response.data.msg !== 'ok'){
                            alertify.error(`Error servidor: ${response.data.msg || response.data}`);
                        }else{
                            db.reportes.delete(reporte.id_reporte);
                            this.obtenerReportes();
                            alertify.success('Eliminado exitosamente');
                        }
                    }).catch(error=>{
                        alertify.error(`Error servidor: ${error}`);
                    });
                });
            },
            async obtenerReportes(){
                try {
                    let strBuscar = this.buscar.toLowerCase();
                    this.reportes = await db.reportes.filter(reporte => {
                        return Object.values(reporte).some(val => 
                            val !== null && val !== undefined && val.toString().toLowerCase().includes(strBuscar)
                        );
                    }).toArray();
                } catch(e) {
                    console.error('Error reading reportes from local db', e);
                    this.reportes = [];
                }
                
                if( this.reportes.length<1 && this.buscar.length<=0 ){
                    axios({
                        method:'GET',
                        url:'reporte',
                        headers:{
                            'Content-Type':'application/json',
                            'Accept':'application/json'
                        }
                    }).then(response=>{
                        this.reportes = response.data;
                        try {
                            if(this.reportes.length > 0){
                                db.reportes.bulkPut(response.data);
                            }
                        } catch(e) { console.error('Error saving reportes to local db', e); }
                    }).catch(error=>{
                        console.log(`Error al conectar con el servidor: ${error}`);
                    });
                }
            }
        },
        created(){
            this.obtenerReportes();
        }
    }
</script>
