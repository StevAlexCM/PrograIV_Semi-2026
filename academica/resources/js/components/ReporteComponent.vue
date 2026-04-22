<template>
    <div v-draggable class="component-wrapper">
        <form
            id="frmReportes"
            @submit.prevent="guardarReporte"
            @reset.prevent="limpiarFormulario"
        >
            <div class="card shadow-lg border-0 rounded-4" style="width: 550px;">
                <div class="card-header bg-danger bg-gradient text-white py-3 border-0 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold"><i class="bi bi-exclamation-triangle me-2"></i>Reporte de Fallas</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            aria-label="Close"
                            @click="cerrarFormularioReporte"
                        ></button>
                    </div>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    placeholder="ID de Usuario"
                                    required
                                    v-model="reporte.id_usuario"
                                    type="number"
                                    class="form-control bg-light border-0"
                                    id="repIdUsuario"
                                />
                                <label for="repIdUsuario" class="text-muted"><i class="bi bi-person me-1"></i>ID Usuario</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    required
                                    v-model="reporte.fecha_reporte"
                                    type="datetime-local"
                                    class="form-control bg-light border-0"
                                    id="repFecha"
                                />
                                <label for="repFecha" class="text-muted"><i class="bi bi-clock-history me-1"></i>Fecha Reporte</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input
                                    placeholder="Ej. Fuga de agua, Tubo roto..."
                                    required
                                    v-model="reporte.tipo_falla"
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="repFalla"
                                />
                                <label for="repFalla" class="text-muted"><i class="bi bi-tools me-1"></i>Tipo de Falla</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea
                                    placeholder="Descripción del problema"
                                    v-model="reporte.descripcion"
                                    class="form-control bg-light border-0"
                                    id="repDesc"
                                    style="height: 100px; resize: none;"
                                ></textarea>
                                <label for="repDesc" class="text-muted"><i class="bi bi-card-text me-1"></i>Descripción detallada</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input
                                    placeholder="Dirección exacta"
                                    v-model="reporte.direccion"
                                    class="form-control bg-light border-0"
                                    id="repDir"
                                />
                                <label for="repDir" class="text-muted"><i class="bi bi-geo-alt me-1"></i>Dirección</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input
                                    placeholder="Zona o sector"
                                    v-model="reporte.zona"
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="repZona"
                                />
                                <label for="repZona" class="text-muted"><i class="bi bi-map me-1"></i>Zona / Sector</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 p-4 pt-0 rounded-bottom-4">
                    <div class="d-flex justify-content-between gap-2">
                        <button type="submit" id="btnGuardarReporte" class="btn btn-danger flex-grow-1 rounded-pill fw-medium shadow-sm"><i class="bi bi-save me-1"></i>Guardar Reporte</button>
                        <button type="reset" id="btnCancelarReporte" class="btn btn-outline-secondary rounded-pill fw-medium"><i class="bi bi-file-earmark-plus me-1"></i>Nuevo</button>
                        <button type="button" @click="buscarReporte" id="btnBuscarReporte" class="btn btn-outline-success rounded-pill fw-medium"><i class="bi bi-search me-1"></i>Buscar</button>
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
            reporte: {
                id_reporte: "",
                id_usuario: "",
                fecha_reporte: "",
                tipo_falla: "",
                descripcion: "",
                direccion: "",
                zona: ""
            },
            accion: "nuevo",
        };
    },
    methods: {
        cerrarFormularioReporte() {
            this.forms.reportes.mostrar = false;
        },
        buscarReporte() {
            this.forms.buscar_reportes.mostrar = !this.forms.buscar_reportes.mostrar;
            this.$emit("buscar");
        },
        modificarReporte(reporte) {
            this.accion = "modificar";
            this.reporte = { ...reporte };
        },
        async guardarReporte() {
            let reporte = { ...this.reporte },
                metodo = "POST";
            
            if (this.accion == "nuevo") {
                delete reporte.id_reporte;
            } else {
                metodo = "PUT";
            }
            
            axios({
                method: metodo,
                url: "reporte",
                data: reporte,
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
                    alertify.success('Reporte guardado exitosamente');
                    if(response.data.data) {
                        try {
                            db.reportes.put(response.data.data);
                        } catch(e) { console.error(e); }
                    }
                }
            })
            .catch((error) => {
                alertify.error(`Error servidor: ${error}`);
            });
        },
        limpiarFormulario() {
            this.reporte = {
                id_reporte: "",
                id_usuario: "",
                fecha_reporte: "",
                tipo_falla: "",
                descripcion: "",
                direccion: "",
                zona: ""
            };
            this.accion = "nuevo";
        },
    },
};
</script>
