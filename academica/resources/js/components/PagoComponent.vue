<template>
    <div v-draggable class="component-wrapper">
        <form
            id="frmPagos"
            @submit.prevent="guardarPago"
            @reset.prevent="limpiarFormulario"
        >
            <div class="card shadow-lg border-0 rounded-4" style="width: 380px;">
                <div class="card-header bg-primary bg-gradient text-white py-3 border-0 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold"><i class="bi bi-wallet2 me-2"></i>Registro de Pagos</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            aria-label="Close"
                            @click="cerrarFormularioPago"
                        ></button>
                    </div>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="form-floating mb-3">
                        <input
                            placeholder="ID de Usuario"
                            required
                            v-model="pago.id_usuario"
                            type="number"
                            class="form-control bg-light border-0"
                            id="floatingIdUsuario"
                        />
                        <label for="floatingIdUsuario" class="text-muted"><i class="bi bi-person me-1"></i>ID Usuario</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            required
                            v-model="pago.fecha_pago"
                            type="datetime-local"
                            class="form-control bg-light border-0"
                            id="floatingFechaPago"
                        />
                        <label for="floatingFechaPago" class="text-muted"><i class="bi bi-calendar-event me-1"></i>Fecha de Pago</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input
                            placeholder="Mes (ej. Enero)"
                            required
                            v-model="pago.mes_facturado"
                            type="text"
                            class="form-control bg-light border-0"
                            id="floatingMes"
                        />
                        <label for="floatingMes" class="text-muted"><i class="bi bi-calendar-check me-1"></i>Mes Facturado</label>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 p-4 pt-0 rounded-bottom-4">
                    <div class="d-flex justify-content-between gap-2">
                        <button type="submit" id="btnGuardarPago" class="btn btn-primary flex-grow-1 rounded-pill fw-medium shadow-sm"><i class="bi bi-save me-1"></i>Guardar</button>
                        <button type="reset" id="btnCancelarPago" class="btn btn-outline-secondary rounded-pill fw-medium"><i class="bi bi-file-earmark-plus me-1"></i>Nuevo</button>
                        <button type="button" @click="buscarPago" id="btnBuscarPago" class="btn btn-outline-success rounded-pill fw-medium"><i class="bi bi-search me-1"></i>Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from "axios";
import alertify from "alertifyjs";

export default {
    props: ["forms"],
    data() {
        return {
            pago: {
                id_pago: "",
                id_usuario: "",
                fecha_pago: "",
                mes_facturado: "",
            },
            accion: "nuevo",
        };
    },
    methods: {
        cerrarFormularioPago() {
            this.forms.pagos.mostrar = false;
        },
        buscarPago() {
            this.forms.buscar_pagos.mostrar = !this.forms.buscar_pagos.mostrar;
            this.$emit("buscar");
        },
        modificarPago(pago) {
            this.accion = "modificar";
            this.pago = { ...pago };
        },
        async guardarPago() {
            let pago = { ...this.pago },
                metodo = "POST";
            
            // Remove id_pago if empty for new creations
            if (this.accion == "nuevo") {
                delete pago.id_pago;
            } else {
                metodo = "PUT";
            }
            
            axios({
                method: metodo,
                url: "pago",
                data: pago,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            })
            .then((response) => {
                if (response.data && response.data.msg !== "ok") {
                    alertify.error(`Respuesta del servidor: ${response.data.msg || response.data}`);
                } else {
                    this.limpiarFormulario();
                    alertify.success('Pago guardado exitosamente');
                    if(response.data.data) {
                        db.pagos.put(response.data.data);
                    }
                }
            })
            .catch((error) => {
                alertify.error(`Error servidor: ${error}`);
            });
        },
        limpiarFormulario() {
            this.pago = {
                id_pago: "",
                id_usuario: "",
                fecha_pago: "",
                mes_facturado: "",
            };
            this.accion = "nuevo";
        },
    },
};
</script>
