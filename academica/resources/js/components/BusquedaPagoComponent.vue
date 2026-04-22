<template>
    <div v-draggable class="component-wrapper">
         <div class="card shadow-lg border-0 rounded-4" style="width: 600px;">
             <div class="card-header bg-primary bg-gradient text-white py-3 border-0 rounded-top-4">
                 <div class="d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-semibold"><i class="bi bi-search me-2"></i>Búsqueda de Pagos</h5>
                     <button type="button" class="btn-close btn-close-white" aria-label="Close" @click="cerrarFormularioBusquedaPagos"></button>
                 </div>
             </div>
             <div class="card-body p-4 bg-white rounded-bottom-4">
                 <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden">
                     <span class="input-group-text bg-light border-0 px-3"><i class="bi bi-search text-muted"></i></span>
                     <input autocomplete="off" type="search" @keyup="obtenerPagos()" v-model="buscar" placeholder="Buscar en cualquier campo..." class="form-control border-0 bg-light shadow-none py-2">
                 </div>
                 
                 <div class="table-responsive">
                     <table class="table table-hover align-middle mb-0" id="tblPagos">
                         <thead class="table-light">
                             <tr>
                                 <th class="border-0 rounded-start text-secondary fw-semibold">ID USUARIO</th>
                                 <th class="border-0 text-secondary fw-semibold">FECHA PAGO</th>
                                 <th class="border-0 text-secondary fw-semibold">MES FACTURADO</th>
                                 <th class="border-0 rounded-end text-center text-secondary fw-semibold">ACCIONES</th>
                             </tr>
                         </thead>
                         <tbody class="border-top-0">
                             <tr v-for="pago in pagos" :key="pago.id_pago" @click="modificarPago(pago)" style="cursor: pointer; transition: all 0.2s;">
                                 <td class="text-dark fw-medium">{{ pago.id_usuario }}</td>
                                 <td class="text-secondary">{{ pago.fecha_pago }}</td>
                                 <td class="text-secondary"><span class="badge bg-info bg-opacity-25 text-primary border border-primary-subtle rounded-pill px-3 py-2">{{ pago.mes_facturado }}</span></td>
                                 <td class="text-center">
                                     <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" @click.stop="eliminarPago(pago)" title="Eliminar">
                                         <i class="bi bi-trash"></i>
                                     </button>
                                 </td>
                             </tr>
                             <tr v-if="pagos.length === 0">
                                 <td colspan="4" class="text-center text-muted py-5"><i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>No se encontraron pagos.</td>
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
                pagos:[],
                buscar:''
            }
        },
        methods:{
            cerrarFormularioBusquedaPagos(){
                this.forms.buscar_pagos.mostrar = false;
            },
            modificarPago(pago){
                this.$emit('modificar', pago);
            },
            eliminarPago(pago){
                alertify.confirm('¿Está seguro de eliminar este pago?', async ()=>{ 
                    axios({
                        method:'DELETE',
                        url:'pago',
                        data:pago,
                        headers:{
                            'Content-Type':'application/json',
                            'Accept':'application/json'
                        }
                    }).then(response=>{
                        if(response.data && response.data.msg !== 'ok'){
                            alertify.error(`Error servidor: ${response.data.msg || response.data}`);
                        }else{
                            db.pagos.delete(pago.id_pago);
                            this.obtenerPagos();
                            alertify.success('Eliminado exitosamente');
                        }
                    }).catch(error=>{
                        alertify.error(`Error servidor: ${error}`);
                    });
                });
            },
            async obtenerPagos(){
                try {
                    let strBuscar = this.buscar.toLowerCase();
                    this.pagos = await db.pagos.filter(pago => {
                        return Object.values(pago).some(val => 
                            val !== null && val !== undefined && val.toString().toLowerCase().includes(strBuscar)
                        );
                    }).toArray();
                } catch(e) {
                    console.error('Error reading from local db', e);
                    this.pagos = [];
                }
                
                if( this.pagos.length<1 && this.buscar.length<=0 ){
                    axios({
                        method:'GET',
                        url:'pago',
                        headers:{
                            'Content-Type':'application/json',
                            'Accept':'application/json'
                        }
                    }).then(response=>{
                        this.pagos = response.data;
                        try {
                            if(this.pagos.length > 0){
                                db.pagos.bulkPut(response.data);
                            }
                        } catch(e) { console.error('Error saving to local db', e); }
                    }).catch(error=>{
                        console.error(`Error al conectar con el servidor: ${error}`);
                    });
                }
            }
        },
        created(){
            this.obtenerPagos();
        }
    }
</script>
