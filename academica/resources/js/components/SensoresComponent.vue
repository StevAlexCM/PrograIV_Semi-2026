<template>
    <div v-draggable class="component-wrapper" style="position: fixed; top: 10%; left: 30%; z-index: 1050;">
        <div class="card shadow-lg border-0 rounded-4" style="width: 500px;">
            <div class="card-header bg-dark text-white py-3 border-0 rounded-top-4" style="cursor: move;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold"><i class="bi bi-sliders me-2"></i>Panel</h5>
                    <button type="button" class="btn-close btn-close-white" @click="cerrarVentana"></button>
                </div>
            </div>
            
            <div class="card-body p-0">
                
                <ul class="nav nav-tabs nav-fill bg-light border-bottom-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold border-0 py-3 text-dark" data-bs-toggle="tab" data-bs-target="#sensores-tab" type="button" role="tab" style="border-radius: 0;">
                            <i class="bi bi-activity"></i> Sensores
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 py-3 text-dark" data-bs-toggle="tab" data-bs-target="#alertas-tab" type="button" role="tab" style="border-radius: 0;">
                            <i class="bi bi-bell-fill"></i> Alertas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 py-3 text-dark" data-bs-toggle="tab" data-bs-target="#gestionar-tab" type="button" role="tab" style="border-radius: 0;" @click="cargarAlertas">
                            <i class="bi bi-megaphone-fill"></i>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 py-3 text-dark" data-bs-toggle="tab" data-bs-target="#usuarios-tab" type="button" role="tab" style="border-radius: 0;" @click="cargarUsuarios">
                            <i class="bi bi-people-fill"></i>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 py-3 text-dark" data-bs-toggle="tab" data-bs-target="#reportes-panel-tab" type="button" role="tab" style="border-radius: 0;" @click="cargarReportes">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </button>
                    </li>
                </ul>

                
                <div class="tab-content p-4">
                    
                    <div class="tab-pane fade show active" id="sensores-tab" role="tabpanel">
                        <form @submit.prevent="actualizarSensores">
                            <p class="text-muted text-center mb-4">Modifica los valores de Calidad de Agua</p>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold text-dark">Nivel de pH actual</label>
                                <input type="number" step="0.1" v-model="sensor.ph_level" class="form-control bg-light" required>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold text-dark">Nivel del tanque (%)</label>
                                <input type="number" v-model="sensor.water_level" class="form-control bg-light" required min="0" max="100">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-medium shadow-sm mb-3">
                                <i class="bi bi-arrow-repeat me-1"></i> Actualizar Sensores
                            </button>
                            <div class="p-3 bg-light rounded text-dark text-center" style="font-size: 0.85rem;">
                                <span class="text-success fw-bold">Verde</span> (6.5-8.5) | <span class="text-warning fw-bold">Amarillo</span> | <span class="text-danger fw-bold">Rojo</span>
                            </div>
                        </form>
                    </div>

                    
                    <div class="tab-pane fade" id="alertas-tab" role="tabpanel">
                        <form @submit.prevent="crearAlerta">
                            <p class="text-muted text-center mb-4">Publicar un nuevo aviso o alerta</p>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Tipo de Alerta</label>
                                <select v-model="alerta.tipo" class="form-select bg-light" required>
                                    <option value="red">Rojo</option>
                                    <option value="yellow">Amarillo</option>
                                    <option value="blue">Azul (Informativo)</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Título</label>
                                <input type="text" v-model="alerta.titulo" class="form-control bg-light" placeholder="Ej. Corte de agua inmediato" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Fecha / Horario</label>
                                <input type="text" v-model="alerta.fecha_texto" class="form-control bg-light" placeholder="Ej. Lunes 28 de abril; todo el día." required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold text-dark">Zona afectada</label>
                                    <input type="text" v-model="alerta.zona" class="form-control bg-light" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold text-dark">Motivo</label>
                                    <input type="text" v-model="alerta.motivo" class="form-control bg-light" required>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label fw-bold text-dark">Descripción extendida (Opcional)</label>
                                <textarea v-model="alerta.descripcion" class="form-control bg-light" rows="2"></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 rounded-pill fw-medium shadow-sm">
                                <i class="bi bi-megaphone me-1"></i> Publicar Alerta
                            </button>
                        </form>
                    </div>

                    
                    <div class="tab-pane fade" id="gestionar-tab" role="tabpanel">
                        <p class="text-muted text-center mb-3">Borrar alertas activas</p>
                        <div v-if="alertasList.length === 0" class="text-center text-muted py-4">
                            <i class="bi bi-check-circle" style="font-size: 2rem;"></i><br>No hay alertas activas
                        </div>
                        <div style="max-height: 350px; overflow-y: auto;" v-else>
                            <div v-for="a in alertasList" :key="a.id" class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-2 border-start border-4" :class="'border-' + (a.tipo == 'red' ? 'danger' : (a.tipo == 'yellow' ? 'warning' : 'primary'))">
                                <div>
                                    <strong class="d-block text-dark" style="font-size: 0.95rem;">{{ a.titulo }}</strong>
                                    <small class="text-muted">{{ a.fecha_texto }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="borrarAlerta(a.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="usuarios-tab" role="tabpanel">
                        <p class="text-muted text-center mb-2">Gestión de roles y estado</p>
                        <div class="px-2 mb-3">
                            <div class="input-group input-group-sm border rounded">
                                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                                <input type="text" v-model="searchUsuarios" class="form-control border-0 shadow-none" placeholder="Buscar usuario por nombre o cuenta...">
                            </div>
                        </div>
                        <div style="max-height: 350px; overflow-y: auto;">
                            <div v-for="u in filteredUsuarios" :key="u.id_usuario" class="bg-light p-3 rounded mb-3 shadow-sm border mx-2">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ u.nombre_completo || 'Usuario sin nombre' }}</h6>
                                        <small class="text-muted">Acc: {{ u.correo_usuario }}</small>
                                    </div>
                                    <span class="badge" :class="u.is_active ? 'bg-success' : 'bg-secondary'">
                                        {{ u.is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-6">
                                        <select v-model="u.rol" class="form-select form-select-sm" @change="actualizarUsuario(u)">
                                            <option value="usuario">Usuario</option>
                                            <option value="admin">Administrador</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" v-model="u.is_active" :true-value="1" :false-value="0" @change="actualizarUsuario(u)">
                                            <label class="form-check-label small">Habilitado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reportes-panel-tab" role="tabpanel">
                        <p class="text-muted text-center mb-2">Reportes de la comunidad</p>
                        <div class="px-2 mb-3">
                            <div class="input-group input-group-sm border rounded">
                                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                                <input type="text" v-model="searchReportes" class="form-control border-0 shadow-none" placeholder="Buscar reportes por descripción o zona...">
                            </div>
                        </div>
                        <div v-if="filteredReportes.length === 0" class="text-center text-muted py-4">
                            <i class="bi bi-clipboard-check" style="font-size: 2rem;"></i><br>No hay reportes que coincidan
                        </div>
                        <div style="max-height: 350px; overflow-y: auto;" v-else>
                            <div v-for="r in filteredReportes" :key="r.id_reporte" class="bg-white p-3 rounded mb-3 border shadow-sm mx-2">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="badge bg-primary text-uppercase">{{ r.categoria_de_problema.replace('_', ' ') }}</span>
                                    <small class="text-muted">{{ formatFecha(r.created_at) }}</small>
                                </div>
                                <div class="mb-2">
                                    <p class="mb-1 text-dark"><strong>Problema:</strong> {{ r.descripcion }}</p>
                                    <p class="mb-1 text-dark"><strong>Ubicación:</strong> {{ r.sector_manzana_calle }}</p>
                                    <p class="mb-0 text-muted small"><strong>Contacto:</strong> {{ r.Informacion_de_contacto }}</p>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-danger" @click="borrarReporte(r.id_reporte)">
                                        <i class="bi bi-trash me-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import alertify from "alertifyjs";

export default {
    props: ["forms"],
    data() {
        return {
            sensor: {
                ph_level: 7.2,
                water_level: 75
            },
            alerta: {
                tipo: 'yellow',
                titulo: '',
                fecha_texto: '',
                zona: '',
                motivo: '',
                descripcion: ''
            },
            alertasList: [],
            usuariosList: [],
            reportesList: [],
            searchUsuarios: '',
            searchReportes: ''
        };
    },
    computed: {
        filteredUsuarios() {
            if (!this.searchUsuarios) return this.usuariosList;
            const q = this.searchUsuarios.toLowerCase();
            return this.usuariosList.filter(u => 
                (u.nombre_completo && u.nombre_completo.toLowerCase().includes(q)) ||
                (u.correo_usuario && u.correo_usuario.toLowerCase().includes(q)) ||
                (u.sector_zona && u.sector_zona.toLowerCase().includes(q))
            );
        },
        filteredReportes() {
            if (!this.searchReportes) return this.reportesList;
            const q = this.searchReportes.toLowerCase();
            return this.reportesList.filter(r => 
                (r.descripcion && r.descripcion.toLowerCase().includes(q)) ||
                (r.sector_manzana_calle && r.sector_manzana_calle.toLowerCase().includes(q)) ||
                (r.categoria_de_problema && r.categoria_de_problema.toLowerCase().includes(q)) ||
                (r.Informacion_de_contacto && r.Informacion_de_contacto.toLowerCase().includes(q))
            );
        }
    },
    mounted() {
        this.cargarAlertas();
    },
    methods: {
        cerrarVentana() {
            this.forms.sensores.mostrar = false;
        },
        async actualizarSensores() {
            axios({
                method: "POST",
                url: "/admin/debug-sensores-api",
                data: this.sensor,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            })
            .then((response) => {
                if (response.data && response.data.success) {
                    alertify.success('Sensores actualizados. Recarga para ver cambios.');
                } else {
                    alertify.error('Error al actualizar sensores');
                }
            })
            .catch((error) => {
                alertify.error(`Error de conexión: ${error}`);
            });
        },
        async crearAlerta() {
            axios({
                method: "POST",
                url: "/admin/alertas-api",
                data: this.alerta,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            })
            .then((response) => {
                if (response.data && response.data.success) {
                    alertify.success('Alerta publicada con éxito. Recarga para ver cambios.');
                    // Clear form
                    this.alerta.titulo = '';
                    this.alerta.fecha_texto = '';
                    this.alerta.zona = '';
                    this.alerta.motivo = '';
                    this.alerta.descripcion = '';
                    this.cargarAlertas();
                } else {
                    alertify.error('Error al publicar alerta');
                }
            })
            .catch((error) => {
                alertify.error(`Error de conexión: ${error}`);
            });
        },
        cargarAlertas() {
            axios.get('/admin/alertas-api-list').then(res => {
                this.alertasList = res.data;
            });
        },
        cargarUsuarios() {
            axios.get('/admin/usuarios-api').then(res => {
                this.usuariosList = res.data;
            });
        },
        actualizarUsuario(u) {
            axios.post('/admin/usuarios-rol-api', {
                id_usuario: u.id_usuario,
                rol: u.rol,
                is_active: u.is_active
            }).then(res => {
                if(res.data.success) {
                    alertify.success("Usuario actualizado");
                }
            });
        },
        cargarReportes() {
            axios.get('/admin/reportes-api-list').then(res => {
                this.reportesList = res.data;
            });
        },
        borrarReporte(id) {
            if(!confirm('¿Deseas eliminar este reporte?')) return;
            axios.delete(`/admin/reportes-api/${id}`).then(res => {
                if(res.data.success) {
                    alertify.success("Reporte eliminado");
                    this.cargarReportes();
                }
            });
        },
        formatFecha(fecha) {
            if(!fecha) return '';
            const d = new Date(fecha);
            return d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        async borrarAlerta(id) {
            if(!confirm('¿Estás seguro de borrar esta alerta?')) return;
            try {
                const response = await axios.delete(`/admin/alertas-api/${id}`);
                if (response.data && response.data.success) {
                    alertify.success('Alerta borrada. Recarga para ver cambios.');
                    this.cargarAlertas();
                } else {
                    alertify.error('Error al borrar alerta');
                }
            } catch (error) {
                alertify.error(`Error de conexión: ${error}`);
            }
        }
    }
};
</script>
<style scoped>
.nav-tabs .nav-link.active {
    background-color: white;
    border-bottom: 3px solid #1b3650 !important;
    color: #1b3650 !important;
}
.nav-tabs .nav-link {
    color: #6a8ba3 !important;
    border-bottom: 3px solid transparent !important;
}
.nav-tabs .nav-link:hover {
    border-bottom: 3px solid #c9dbe6 !important;
}
</style>
