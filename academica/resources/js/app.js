/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import Dexie from 'dexie';
import pagos from './components/PagoComponent.vue';
import buscar_pagos from './components/BusquedaPagoComponent.vue';
import reportes from './components/ReporteComponent.vue';
import buscar_reportes from './components/BusquedaReporteComponent.vue';
import { vDraggable } from './draggable';

window.db = new Dexie('db_pagos_reportes');

createApp({
    components: {
        pagos,
        buscar_pagos,
        reportes,
        buscar_reportes
    },
    data(){
        return{
            forms:{
                pagos:{mostrar:false},
                buscar_pagos:{mostrar:false},

                reportes:{mostrar:false},
                buscar_reportes:{mostrar:false}
            }
        };
    },
    methods:{
        buscar(ventana, metodo){
            this.$refs[ventana][metodo]();
        },
        abrirVentana(ventana){
            console.log(ventana);
            this.forms[ventana].mostrar = !this.forms[ventana].mostrar;
        },
        modificar(ventana, metodo, data){
            this.$refs[ventana][metodo](data);
        },
        hacerBackup(){
            alertify.alert('Backup', 'Función de backup no implementada aún');
        }
    },
    created(){
        db.version(4).stores({
            pagos:'id_pago, id_usuario, fecha_pago, mes_facturado',
            reportes:'id_reporte, id_usuario, fecha_reporte, tipo_falla, descripcion, direccion, zona'
        });
    }
}).directive('draggable', vDraggable).mount('#appSistema');
