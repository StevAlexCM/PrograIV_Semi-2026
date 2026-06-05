<template>
  <div class="dashboard-container p-4">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
      <div class="col-md-6">
        <h1 class="h2 fw-bold text-dark mb-1">¡Bienvenido, {{ adminName }}!</h1>
        <p class="text-muted mb-0">Resumen general del sistema de monitoreo de agua</p>
      </div>
      <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-3 mt-3 mt-md-0">
        <!-- Profile Widget -->
        <div class="d-flex align-items-center gap-2 bg-white px-3 py-2 rounded-pill shadow-sm border">
          <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
            {{ adminInitials }}
          </div>
          <div class="text-start d-none d-lg-block">
            <div class="fw-semibold text-dark leading-none" style="font-size: 0.85rem;">{{ adminName }}</div>
            <div class="text-muted leading-none" style="font-size: 0.75rem;">Rol: Administrador</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Date selector row -->
    <div class="d-flex justify-content-end mb-4">
      <div class="bg-white px-3 py-1.5 rounded shadow-sm border text-muted d-flex align-items-center gap-2" style="font-size: 0.9rem;">
        <i class="bi bi-calendar3"></i>
        <span>{{ fechaActualTexto }}</span>
      </div>
    </div>

    <!-- Stats Cards Row (4 cards) -->
    <div class="row g-4 mb-4">
      <!-- Card 1: Estado del Agua -->
      <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-wrapper rounded-4 p-3 d-flex align-items-center justify-content-center" :class="phStatusClass.bg">
              <i class="bi bi-droplet-fill fs-3" :class="phStatusClass.text"></i>
            </div>
            <div>
              <div class="text-muted fw-medium small">Estado general del agua</div>
              <div class="fs-4 fw-bold text-uppercase" :class="phStatusClass.text">{{ phStatusText }}</div>
              <div class="text-muted extra-small">pH actual: {{ sensor.ph_level }}</div>
            </div>
          </div>
          <!-- Sparkline -->
          <div class="mt-3 pt-2 border-top">
            <svg class="w-100" height="35" viewBox="0 0 100 35" preserveAspectRatio="none">
              <path :d="sparklinePath" fill="none" :stroke="phStatusClass.color" stroke-width="2" stroke-linecap="round" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Card 2: Estaciones activas -->
      <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-wrapper rounded-4 p-3 bg-success-subtle d-flex align-items-center justify-content-center">
              <i class="bi bi-broadcast fs-3 text-success"></i>
            </div>
            <div>
              <div class="text-muted fw-medium small">Estaciones activas</div>
              <div class="fs-4 fw-bold text-dark">24</div>
              <div class="text-muted extra-small">De 28 estaciones</div>
            </div>
          </div>
          <!-- Progress bar -->
          <div class="mt-4">
            <div class="d-flex justify-content-between text-muted extra-small mb-1">
              <span>Nivel Promedio Tanque</span>
              <span>{{ sensor.water_level }}%</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-success" role="progressbar" :style="{ width: sensor.water_level + '%' }" :aria-valuenow="sensor.water_level" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 3: Alertas activas -->
      <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-wrapper rounded-4 p-3 bg-warning-subtle d-flex align-items-center justify-content-center">
              <i class="bi bi-exclamation-triangle-fill fs-3 text-warning"></i>
            </div>
            <div>
              <div class="text-muted fw-medium small">Alertas activas</div>
              <div class="fs-4 fw-bold text-dark">{{ activeAlertsCount }}</div>
              <div class="text-muted extra-small">Requieren atención</div>
            </div>
          </div>
          <!-- Link -->
          <div class="mt-4 pt-1">
            <a href="#console-section" class="text-decoration-none text-primary fw-semibold small" @click="activarTab('alertas')">
              Ver alertas <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Card 4: Usuarios registrados -->
      <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-wrapper rounded-4 p-3 bg-info-subtle d-flex align-items-center justify-content-center">
              <i class="bi bi-people-fill fs-3 text-info"></i>
            </div>
            <div>
              <div class="text-muted fw-medium small">Usuarios registrados</div>
              <div class="fs-4 fw-bold text-dark">{{ totalUsersCount }}</div>
              <div class="text-success extra-small fw-semibold">
                <i class="bi bi-arrow-up-right me-1"></i>+12% vs. mes ant.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row g-4 mb-4">
      <!-- Quality Chart (Left) -->
      <div class="col-xl-8">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h2 class="h5 fw-bold text-dark mb-1">Calidad del agua - Resumen</h2>
              <p class="text-muted extra-small mb-0">Lecturas de pH en el tiempo</p>
            </div>
            <select class="form-select form-select-sm w-auto" v-model="chartPeriod">
              <option value="15">Últimas 15 lecturas</option>
              <option value="7">Últimas 7 lecturas</option>
            </select>
          </div>
          <div class="chart-container position-relative" style="height: 320px;">
            <canvas id="qualityChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Alerts List (Right) -->
      <div class="col-xl-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold text-dark mb-0">Alertas recientes</h2>
            <a href="#console-section" class="text-decoration-none small text-primary fw-semibold" @click="activarTab('alertas')">
              Ver todas
            </a>
          </div>
          
          <div class="alerts-list overflow-y-auto pr-1" style="max-height: 320px;">
            <div v-if="alertasList.length === 0" class="text-center text-muted py-5">
              <i class="bi bi-check-circle fs-2 text-success mb-2 d-block"></i>
              No hay alertas activas en el sistema
            </div>
            <div v-else v-for="a in alertasList" :key="a.id" class="alert-item d-flex gap-3 p-3 rounded-3 mb-2 border-start border-4 align-items-start" :class="alertItemClass(a.tipo)">
              <div class="alert-icon-circle rounded-circle d-flex align-items-center justify-content-center p-1.5" :class="alertBadgeClass(a.tipo)">
                <i class="bi" :class="a.tipo === 'red' ? 'bi-exclamation-octagon-fill' : (a.tipo === 'yellow' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill')"></i>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <h6 class="mb-0 fw-bold text-dark small">{{ a.titulo }}</h6>
                  <span class="badge extra-small text-uppercase" :class="alertBadgeClass(a.tipo)">
                    {{ a.tipo === 'red' ? 'Alta' : (a.tipo === 'yellow' ? 'Media' : 'Info') }}
                  </span>
                </div>
                <p class="text-muted extra-small mb-1">{{ a.descripcion || a.motivo }}</p>
                <div class="text-muted extra-extra-small d-flex justify-content-between">
                  <span><i class="bi bi-geo-alt-fill me-1"></i>{{ a.zona }}</span>
                  <span><i class="bi bi-clock me-1"></i>{{ formatAlertFecha(a.fecha_texto) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Activity Row (Expanded) -->
    <div class="row g-4 mb-5">
      <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h2 class="h5 fw-bold text-dark mb-1">Actividad del sistema</h2>
              <p class="text-muted extra-small mb-0">Eventos del sistema y acciones administrativas en tiempo real</p>
            </div>
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" @click="cargarActividades">
              <i class="bi bi-arrow-clockwise me-1"></i>Actualizar
            </button>
          </div>
          <div class="activity-log overflow-y-auto pr-1" style="max-height: 350px;">
            <div v-if="activityList.length === 0" class="text-center text-muted py-5">
              <i class="bi bi-info-circle fs-2 mb-2 d-block"></i>
              No hay actividades registradas en el sistema.
            </div>
            <div v-else class="activity-item d-flex gap-3 position-relative pb-3" v-for="(act, idx) in activityList" :key="idx">
              <!-- Line connector -->
              <div v-if="idx < activityList.length - 1" class="position-absolute start-4.5 top-5 h-100 border-start" style="left: 17px; z-index: 1;"></div>
              
              <div class="activity-dot rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm border border-2" :class="act.color" style="width: 36px; height: 36px; z-index: 2; flex-shrink: 0;">
                <i class="bi fs-6" :class="act.icon"></i>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                  <h6 class="mb-0.5 fw-bold text-dark small" style="font-size: 0.85rem;">{{ act.titulo }}</h6>
                  <span class="text-muted extra-extra-small">{{ act.tiempo }}</span>
                </div>
                <p class="text-muted extra-small mb-0">{{ act.descripcion }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Administration Console (The improved version of debug sensors + general management) -->
    <div id="console-section" class="card border-0 rounded-4 shadow-lg overflow-hidden mb-4">
      <div class="card-header bg-dark text-white border-0 p-3.5 d-flex align-items-center gap-2">
        <i class="bi bi-shield-fill-check fs-4 text-warning"></i>
        <h5 class="mb-0 fw-bold">Consola de Control de Administración</h5>
      </div>

      <!-- Tab Buttons -->
      <ul class="nav nav-tabs nav-fill bg-light border-bottom" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active py-3 fw-semibold border-0 text-dark" id="sensores-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-sensores" type="button" role="tab" aria-controls="tab-sensores" aria-selected="true">
            <i class="bi bi-sliders me-2"></i>Simulador de Sensores
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link py-3 fw-semibold border-0 text-dark" id="alertas-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-alertas" type="button" role="tab" aria-controls="tab-alertas" aria-selected="false">
            <i class="bi bi-bell-fill me-2"></i>Gestión de Alertas
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link py-3 fw-semibold border-0 text-dark" id="usuarios-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-usuarios" type="button" role="tab" aria-controls="tab-usuarios" aria-selected="false" @click="cargarUsuarios">
            <i class="bi bi-people-fill me-2"></i>Gestión de Usuarios
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link py-3 fw-semibold border-0 text-dark" id="reportes-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-reportes" type="button" role="tab" aria-controls="tab-reportes" aria-selected="false" @click="cargarReportes">
            <i class="bi bi-file-earmark-text-fill me-2"></i>Reportes Comunidad
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link py-3 fw-semibold border-0 text-dark" id="facturacion-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-facturacion" type="button" role="tab" aria-controls="tab-facturacion" aria-selected="false" @click="cargarPagos">
            <i class="bi bi-receipt me-2"></i>Facturación y Recibos
          </button>
        </li>
      </ul>

      <!-- Tab Contents -->
      <div class="card-body p-4 bg-white tab-content">
        <!-- TAB 1: SENSORES -->
        <div class="tab-pane show active fade" id="tab-sensores" role="tabpanel" aria-labelledby="sensores-tab-btn">
          <div class="row g-4 align-items-center">
            <div class="col-lg-6">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-activity text-primary me-2"></i>Simular Lectura de Sensores</h6>
              <form @submit.prevent="actualizarSensores">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted small">Nivel de pH actual (Rango seguro: 6.5 - 8.5)</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-droplet-half"></i></span>
                    <input type="number" step="0.1" v-model="sensorForm.ph_level" class="form-control" placeholder="Ej. 7.2" required>
                  </div>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-semibold text-muted small">Nivel del tanque (%)</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                    <input type="number" v-model="sensorForm.water_level" class="form-control" placeholder="Ej. 75" required min="0" max="100">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium" :disabled="guardandoSensores">
                  <span v-if="guardandoSensores" class="spinner-border spinner-border-sm me-2"></span>
                  <i v-else class="bi bi-arrow-repeat me-1"></i> Actualizar Simulador
                </button>
              </form>
            </div>
            
            <div class="col-lg-6">
              <div class="bg-light p-4 rounded-4 border">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-info me-2"></i>Guía de Indicadores Rápidos</h6>
                <div class="d-flex flex-column gap-2">
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success" style="width: 80px;">Normal</span>
                    <span class="text-muted small">pH entre 6.5 y 8.5. (Agua completamente potable)</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark" style="width: 80px;">Revisar</span>
                    <span class="text-muted small">pH 6.0 - 6.4 ó 8.6 - 9.0. (Precaución)</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger" style="width: 80px;">Peligro</span>
                    <span class="text-muted small">pH menor a 6.0 ó mayor a 9.0. (No apta)</span>
                  </div>
                </div>
                <p class="text-muted extra-small mt-3 mb-0">* Los valores alterados aquí impactan a todas las vistas públicas en tiempo real.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB 2: ALERTAS -->
        <div class="tab-pane fade" id="tab-alertas" role="tabpanel" aria-labelledby="alertas-tab-btn">
          <div class="row g-4">
            <!-- Create Alert -->
            <div class="col-lg-6 border-end">
              <h6 class="fw-bold text-dark mb-3">
                <i class="bi bi-megaphone-fill me-2" :class="alertaForm.tipo === 'red' ? 'text-danger' : (alertaForm.tipo === 'blue' ? 'text-primary' : 'text-warning')"></i>
                Publicar Nueva Alerta de Sistema
              </h6>
              <form @submit.prevent="crearAlerta">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Tipo de Alerta</label>
                    <select v-model="alertaForm.tipo" class="form-select" required>
                      <option value="red">Alta (Rojo)</option>
                      <option value="yellow">Media (Amarillo)</option>
                      <option value="blue">Informativa (Azul)</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Zona Afectada</label>
                    <input type="text" v-model="alertaForm.zona" class="form-control" placeholder="Ej. Zona Norte" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted small">Título de Alerta</label>
                  <input type="text" v-model="alertaForm.titulo" class="form-control" placeholder="Ej. Corte de agua por mantenimiento" required>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Fecha del Evento (Calendario)</label>
                    <input type="date" v-model="alertaForm.fecha_limite" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Hora de Inicio (AM/PM)</label>
                    <div class="d-flex gap-2">
                      <select v-model="alertaForm.hora_12" class="form-select" required>
                        <option value="" disabled selected>Hora</option>
                        <option v-for="h in 12" :key="h" :value="h.toString().padStart(2, '0')">{{ h }}</option>
                      </select>
                      <select v-model="alertaForm.minutos" class="form-select" required>
                        <option value="" disabled selected>Min</option>
                        <option v-for="m in 60" :key="m-1" :value="(m-1).toString().padStart(2, '0')">
                          {{ (m-1).toString().padStart(2, '0') }}
                        </option>
                      </select>
                      <select v-model="alertaForm.periodo" class="form-select" required>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted small">Motivo</label>
                  <input type="text" v-model="alertaForm.motivo" class="form-control" placeholder="Ej. Reparación de tubería" required>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted small">Descripción extendida</label>
                  <textarea v-model="alertaForm.descripcion" class="form-control" rows="3" placeholder="Detalles de la alerta..."></textarea>
                </div>

                <button type="submit" class="btn rounded-pill px-4 fw-medium" :class="alertaForm.tipo === 'red' ? 'btn-danger text-white' : (alertaForm.tipo === 'blue' ? 'btn-primary text-white' : 'btn-warning text-dark')" :disabled="guardandoAlerta">
                  <span v-if="guardandoAlerta" class="spinner-border spinner-border-sm me-2"></span>
                  <i v-else class="bi bi-send-fill me-1"></i> Publicar Alerta
                </button>
              </form>
            </div>

            <!-- Manage Active Alerts -->
            <div class="col-lg-6">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-trash-fill text-muted me-2"></i>Alertas Activas en el Sistema</h6>
              <div class="overflow-y-auto" style="max-height: 380px;">
                <div v-if="alertasList.length === 0" class="text-center text-muted py-5">
                  No hay alertas activas para borrar
                </div>
                <div v-else v-for="a in alertasList" :key="a.id" class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-2 border">
                  <div>
                    <span class="badge text-uppercase me-2" :class="alertBadgeClass(a.tipo)">{{ a.tipo === 'red' ? 'Rojo' : (a.tipo === 'yellow' ? 'Amarillo' : 'Azul') }}</span>
                    <strong class="text-dark small">{{ a.titulo }}</strong>
                    <div class="text-muted extra-small mt-1"><i class="bi bi-geo-alt me-1"></i>{{ a.zona }} | {{ formatAlertFecha(a.fecha_texto) }}</div>
                  </div>
                  <button type="button" class="btn btn-outline-danger btn-sm rounded-circle p-2" @click="borrarAlerta(a.id)">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB 3: USUARIOS -->
        <div class="tab-pane fade" id="tab-usuarios" role="tabpanel" aria-labelledby="usuarios-tab-btn">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-primary me-2"></i>Control de Roles y Cuentas de Acceso</h6>
            <!-- Table Search -->
            <div class="input-group input-group-sm w-auto">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Filtrar usuarios..." v-model="searchUsuarios">
            </div>
          </div>

          <div class="table-responsive rounded-3 border overflow-hidden">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
              <thead class="table-dark">
                <tr>
                  <th>Nombre Completo</th>
                  <th>Cuenta / Correo</th>
                  <th>Sector / Zona</th>
                  <th style="width: 160px;">Rol</th>
                  <th style="width: 140px;">Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="filteredUsuarios.length === 0">
                  <td colspan="5" class="text-center py-4 text-muted">No se encontraron usuarios</td>
                </tr>
                <tr v-else v-for="u in filteredUsuarios" :key="u.id_usuario">
                  <td class="fw-semibold text-dark">{{ u.nombre_completo || 'Usuario sin nombre' }}</td>
                  <td><code>{{ u.correo_usuario }}</code></td>
                  <td>{{ u.sector_zona }}</td>
                  <td>
                    <select v-model="u.rol" class="form-select form-select-sm" @change="actualizarUsuario(u)">
                      <option value="usuario">Usuario</option>
                      <option value="admin">Administrador</option>
                    </select>
                  </td>
                  <td>
                    <div class="form-check form-switch mb-0">
                      <input class="form-check-input" type="checkbox" v-model="u.is_active" :true-value="1" :false-value="0" @change="actualizarUsuario(u)">
                      <span class="badge ms-1" :class="u.is_active ? 'bg-success' : 'bg-secondary'">
                        {{ u.is_active ? 'Activo' : 'Inactivo' }}
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 4: REPORTES -->
        <div class="tab-pane fade" id="tab-reportes" role="tabpanel" aria-labelledby="reportes-tab-btn">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-text-fill text-primary me-2"></i>Reportes de Falla Recibidos</h6>
            <div class="input-group input-group-sm w-auto">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Filtrar reportes..." v-model="searchReportes">
            </div>
          </div>

          <div class="row g-3">
            <div v-if="filteredReportes.length === 0" class="col-12 text-center text-muted py-5 border rounded-3 bg-light">
              <i class="bi bi-clipboard-check fs-2 text-muted mb-2 d-block"></i>
              No hay reportes de falla en esta sección.
            </div>
            <div v-else class="col-md-6 col-xl-4" v-for="r in filteredReportes" :key="r.id_reporte">
              <div class="card border rounded-4 shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2.5 px-3">
                  <span class="badge bg-primary text-uppercase" style="font-size: 0.7rem;">
                    {{ r.categoria_de_problema ? r.categoria_de_problema.replace('_', ' ') : 'Reporte' }}
                  </span>
                  <small class="text-muted extra-extra-small">{{ formatFecha(r.created_at) }}</small>
                </div>
                <div class="card-body p-3">
                  <p class="mb-2 text-dark small"><strong>Detalle:</strong> {{ r.descripcion }}</p>
                  <p class="mb-2 text-dark small"><i class="bi bi-geo-alt-fill text-muted me-1"></i><strong>Ubicación:</strong> {{ r.sector_manzana_calle }}</p>
                  <p class="mb-0 text-muted extra-small"><i class="bi bi-person-fill text-muted me-1"></i><strong>Contacto:</strong> {{ r.Informacion_de_contacto }}</p>
                </div>
                <div class="card-footer bg-white border-top-0 p-3 pt-0 text-end">
                  <button class="btn btn-sm btn-outline-danger rounded-pill" @click="borrarReporte(r.id_reporte)">
                    <i class="bi bi-check2-circle me-1"></i> Resolver / Eliminar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB 5: FACTURACIÓN Y RECIBOS -->
        <div class="tab-pane fade" id="tab-facturacion" role="tabpanel" aria-labelledby="facturacion-tab-btn">
          <div class="row g-4">
            <!-- Col 1: Generador de Recibos -->
            <div class="col-lg-5 border-end">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-calculator-fill text-primary me-2"></i>Generación de Recibo por Consumo</h6>
              <form @submit.prevent="crearRecibo">
                <div class="row g-3 mb-3">
                  <div class="col-md-12">
                    <label class="form-label fw-semibold text-muted small">Seleccionar Usuario (Número de Cuenta)</label>
                    
                    <!-- Search input with magnifying glass (lupa de búsqueda) -->
                    <div class="input-group input-group-sm mb-2 shadow-sm border rounded-pill overflow-hidden bg-light" style="max-width: 100%;">
                      <span class="input-group-text bg-transparent border-0 px-3"><i class="bi bi-search text-muted"></i></span>
                      <input autocomplete="off" type="search" v-model="searchUsuarioPago" placeholder="Buscar por cuenta, nombre o correo..." class="form-control border-0 bg-transparent shadow-none py-1.5">
                    </div>

                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                      <select v-model="pagoForm.id_usuario" class="form-select" required @change="buscarLecturaAnterior">
                        <option value="" disabled>-- Seleccione un usuario / cuenta --</option>
                        <option v-for="u in usuariosFiltradosPago" :key="u.id_usuario" :value="u.id_usuario">
                          Cuenta #{{ u.id_usuario }} - {{ u.nombre_completo || 'Usuario sin nombre' }} ({{ u.correo_usuario }})
                        </option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Mes Facturado</label>
                    <select v-model="pagoForm.mes" class="form-select" required>
                      <option value="Enero">Enero</option>
                      <option value="Febrero">Febrero</option>
                      <option value="Marzo">Marzo</option>
                      <option value="Abril">Abril</option>
                      <option value="Mayo">Mayo</option>
                      <option value="Junio">Junio</option>
                      <option value="Julio">Julio</option>
                      <option value="Agosto">Agosto</option>
                      <option value="Septiembre">Septiembre</option>
                      <option value="Octubre">Octubre</option>
                      <option value="Noviembre">Noviembre</option>
                      <option value="Diciembre">Diciembre</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Año</label>
                    <select v-model="pagoForm.anio" class="form-select" required>
                      <option value="2026">2026</option>
                      <option value="2027">2027</option>
                      <option value="2028">2028</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label fw-semibold text-muted small mb-0">Lectura Anterior (m³)</label>
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="overrideLectura" v-model="pagoForm.override">
                      <label class="form-check-label extra-small text-muted" for="overrideLectura">
                        Modificar manualmente
                      </label>
                    </div>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-arrow-left-square"></i></span>
                    <input type="number" step="0.01" v-model="pagoForm.lectura_anterior" class="form-control bg-light" :readonly="!pagoForm.override" placeholder="Cargando automáticamente..." required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted small">Lectura Actual (m³)</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-arrow-right-square-fill"></i></span>
                    <input type="number" step="0.01" v-model="pagoForm.lectura_actual" class="form-control" placeholder="Ingrese medición actual" required>
                  </div>
                </div>

                <!-- Detalle de cobro en vivo -->
                <div class="bg-light p-3 rounded-4 border mb-3">
                  <h6 class="fw-bold text-dark mb-2 extra-small text-uppercase tracking-wider">Desglose del Recibo</h6>
                  <div class="d-flex flex-column gap-2 text-muted small">
                    <div class="d-flex justify-content-between">
                      <span>Consumo del Mes:</span>
                      <span class="fw-semibold text-dark">{{ consumoCalculado }} m³</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Cuota Base Fija:</span>
                      <span>$4.50</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Costo por Consumo (m³ × $1.50):</span>
                      <span>${{ costoConsumoCalculado }}</span>
                    </div>
                    <div class="d-flex justify-content-between pb-2 border-bottom text-danger" v-if="saldoPendienteAcumulado > 0">
                      <span>Deuda Pendiente Acumulada:</span>
                      <span class="fw-semibold">${{ saldoPendienteAcumulado }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-1 fw-bold text-dark fs-6">
                      <span>Total a Pagar:</span>
                      <span class="text-primary">${{ totalPagarCalculado }}</span>
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2.5 fw-bold" :disabled="guardandoPago || lecturaActualInvalida">
                  <span v-if="guardandoPago" class="spinner-border spinner-border-sm me-2"></span>
                  <i v-else class="bi bi-file-earmark-pdf-fill me-1"></i> Generar Recibo de Pago
                </button>
                <div v-if="lecturaActualInvalida" class="text-danger extra-small mt-2 text-center">
                  <i class="bi bi-exclamation-circle-fill me-1"></i> La lectura actual no puede ser menor a la lectura anterior.
                </div>
              </form>
            </div>

            <!-- Col 2: Historial de Recibos -->
            <div class="col-lg-7">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-journal-text me-2 text-muted"></i>Recibos Emitidos</h6>
                <div class="input-group input-group-sm w-auto">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input type="text" class="form-control" placeholder="Buscar recibo..." v-model="searchPagos">
                </div>
              </div>

              <div class="table-responsive rounded-3 border overflow-hidden">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                  <thead class="table-dark">
                    <tr>
                      <th style="width: 75px;">Cuenta</th>
                      <th>Mes / Periodo</th>
                      <th>Lecturas (Ant / Act)</th>
                      <th>Consumo</th>
                      <th>Total</th>
                      <th>Estado</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="filteredPagos.length === 0">
                      <td colspan="7" class="text-center py-4 text-muted">No se encontraron recibos de pago</td>
                    </tr>
                    <tr v-else v-for="p in filteredPagos" :key="p.id_pago">
                      <td class="fw-semibold text-dark">#{{ p.id_usuario }}</td>
                      <td>
                        <span class="badge bg-secondary-subtle text-dark border">{{ p.mes_facturado }}</span>
                      </td>
                      <td>{{ parseFloat(p.lectura_anterior).toFixed(1) }} / {{ parseFloat(p.lectura_actual).toFixed(1) }} m³</td>
                      <td class="fw-medium text-dark">{{ parseFloat(p.consumo).toFixed(1) }} m³</td>
                      <td class="fw-bold text-primary">${{ parseFloat(p.total_pagar).toFixed(2) }}</td>
                      <td>
                        <span class="badge rounded-pill px-2.5 py-1.5" :class="p.estado_pago === 'Pagado' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning'" style="cursor: pointer;" @click="cambiarEstadoPago(p)">
                          {{ p.estado_pago || 'Pendiente' }}
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle p-1.5" @click="imprimirRecibo(p)" title="Imprimir Recibo">
                            <i class="bi bi-printer-fill"></i>
                          </button>
                          <button type="button" class="btn btn-outline-danger btn-sm rounded-circle p-1.5" @click="borrarPago(p.id_pago)" title="Eliminar Recibo">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Estructura del reicbooooooo -->
    <div v-if="ticketReceipt" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-50" style="z-index: 2000;">
      <div class="card border-0 rounded-4 shadow-lg overflow-hidden" style="width: 380px; max-height: 90vh;">
        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center border-0">
          <h6 class="mb-0 fw-bold"><i class="bi bi-printer me-2 text-warning"></i>Imprimir Recibo</h6>
          <button type="button" class="btn-close btn-close-white" @click="ticketReceipt = null"></button>
        </div>
        <div class="card-body p-4 bg-white overflow-y-auto" id="ticket-print-area">
          <div class="text-center mb-4">
            <h5 class="fw-extrabold text-uppercase text-primary mb-1 tracking-wide">HIDROVIDA.</h5>
            <p class="text-muted extra-small mb-0">Sistema de Control de Agua Potable</p>
            <p class="text-muted extra-small">El Salvador</p>
            <div class="border-top border-dashed my-2"></div>
            <h6 class="fw-bold text-dark mb-0">RECIBO DE CONSUMO MENSUAL</h6>
            <small class="text-muted">Factura No: HVR-{{ ticketReceipt.id_pago }}</small>
          </div>
          
          <div class="extra-small text-dark mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">No. Cuenta / ID:</span>
              <span class="fw-bold">#{{ ticketReceipt.id_usuario }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Periodo Facturado:</span>
              <span class="fw-bold">{{ ticketReceipt.mes_facturado }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Fecha de Emisión:</span>
              <span class="fw-bold">{{ formatFecha(ticketReceipt.fecha_pago || ticketReceipt.created_at) }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Estado:</span>
              <span class="badge" :class="ticketReceipt.estado_pago === 'Pagado' ? 'bg-success text-white' : 'bg-warning text-dark'">
                {{ ticketReceipt.estado_pago || 'Pendiente' }}
              </span>
            </div>
          </div>
          
          <div class="border-top border-dashed my-3"></div>
          
          <h6 class="fw-bold text-dark mb-2 extra-small text-uppercase">Lecturas Registradas</h6>
          <div class="extra-small text-muted d-flex justify-content-between mb-1">
            <span>Lectura Anterior:</span>
            <span class="text-dark">{{ parseFloat(ticketReceipt.lectura_anterior).toFixed(2) }} m³</span>
          </div>
          <div class="extra-small text-muted d-flex justify-content-between mb-1">
            <span>Lectura Actual:</span>
            <span class="text-dark">{{ parseFloat(ticketReceipt.lectura_actual).toFixed(2) }} m³</span>
          </div>
          <div class="extra-small text-muted d-flex justify-content-between mb-2">
            <span>Consumo del Mes:</span>
            <span class="fw-bold text-dark">{{ parseFloat(ticketReceipt.consumo).toFixed(2) }} m³</span>
          </div>
          
          <div class="border-top border-dashed my-3"></div>
          
          <h6 class="fw-bold text-dark mb-2 extra-small text-uppercase">Detalle de Cobro</h6>
          <div class="extra-small text-muted d-flex justify-content-between mb-1">
            <span>Cuota Fija Base:</span>
            <span class="text-dark">$4.50</span>
          </div>
          <div class="extra-small text-muted d-flex justify-content-between mb-2">
            <span>Consumo ({{ parseFloat(ticketReceipt.consumo).toFixed(2) }} m³ x $1.50):</span>
            <span class="text-dark">${{ (parseFloat(ticketReceipt.consumo) * 1.50).toFixed(2) }}</span>
          </div>
          
          <div class="border-top border-dashed my-2"></div>
          
          <div class="d-flex justify-content-between fw-bold text-dark fs-5 py-1">
            <span>Total a Pagar:</span>
            <span class="text-primary">${{ parseFloat(ticketReceipt.total_pagar).toFixed(2) }}</span>
          </div>

          <div class="border-top border-dashed my-2"></div>

          <div v-if="ticketReceipt.estado_pago !== 'Pagado'" class="alert alert-warning py-1.5 px-3 mt-2 text-center border-0 rounded-3 mb-0" style="font-size: 0.72rem;">
            <i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i>
            <strong>Pendiente de Pago:</strong> El usuario debe pagar este recibo.
          </div>
          <div v-else class="alert alert-success py-1.5 px-3 mt-2 text-center border-0 rounded-3 mb-0" style="font-size: 0.72rem;">
            <i class="bi bi-check-circle-fill me-1 text-success"></i>
            <strong>Recibo Pagado:</strong> ¡Gracias por estar al día!
          </div>
          
          <div class="border-top border-dashed my-3"></div>
          
          <div class="text-center mt-3 text-muted extra-extra-small">
            <p class="mb-1">¡Gracias por hacer un uso responsable del agua!</p>
            <p class="mb-0">Para soporte o dudas contáctanos en soporte@hidrovida.com</p>
          </div>
        </div>
        <div class="card-footer bg-light p-3 border-0 d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary w-50 rounded-pill" @click="ticketReceipt = null">Cerrar</button>
          <button type="button" class="btn btn-primary w-50 rounded-pill" @click="printReceiptElement">
            <i class="bi bi-printer me-1"></i> Imprimir
          </button>
        </div>
      </div>
    </div>

    <!-- Footer Note -->
    <div class="text-center text-muted extra-small mt-4">
      <i class="bi bi-info-circle me-1"></i>Los datos del panel se actualizan automáticamente en tiempo real.
    </div>
  </div>
</template>

<script>
import axios from "axios";
import alertify from "alertifyjs";

export default {
  props: {
    adminName: {
      type: String,
      default: 'Administrador'
    }
  },
  data() {
    return {
      sensor: {
        ph_level: 7.2,
        water_level: 75
      },
      sensorHistory: [],
      alertasList: [],
      usuariosList: [],
      reportesList: [],
      pagosList: [],
      
      // Control forms
      sensorForm: {
        ph_level: 7.2,
        water_level: 75
      },
      alertaForm: {
        tipo: 'yellow',
        titulo: '',
        fecha_limite: '',
        hora_limite: '',
        hora_12: '',
        minutos: '',
        periodo: 'AM',
        fecha_texto: '',
        zona: '',
        motivo: '',
        descripcion: ''
      },
      pagoForm: {
        id_usuario: '',
        mes: new Date().toLocaleString('es-ES', { month: 'long' }).charAt(0).toUpperCase() + new Date().toLocaleString('es-ES', { month: 'long' }).slice(1),
        anio: '2026',
        lectura_anterior: 0,
        lectura_actual: '',
        override: false
      },

      
      searchUsuarios: '',
      searchReportes: '',
      searchPagos: '',
      searchUsuarioPago: '',
      chartPeriod: '15',
      
      
      fechaActualTexto: '',
      activityList: [],
      ticketReceipt: null,
      guardandoPago: false,
      
      
      qChartInstance: null
    };
  },
  computed: {
    adminInitials() {
      return this.adminName ? this.adminName.trim().charAt(0).toUpperCase() : 'A';
    },
    activeAlertsCount() {
      return this.alertasList.length;
    },
    totalUsersCount() {
      return this.usuariosList.length || 1248; // Fallback matches design if empty
    },
    phStatusText() {
      const ph = this.sensor.ph_level;
      if (ph >= 6.5 && ph <= 8.5) return 'Seguro';
      if ((ph >= 6.0 && ph < 6.5) || (ph > 8.5 && ph <= 9.0)) return 'Revisión';
      return 'Peligro';
    },
    phStatusClass() {
      const ph = this.sensor.ph_level;
      if (ph >= 6.5 && ph <= 8.5) {
        return { text: 'text-success', bg: 'bg-success-subtle', color: '#198754' };
      }
      if ((ph >= 6.0 && ph < 6.5) || (ph > 8.5 && ph <= 9.0)) {
        return { text: 'text-warning', bg: 'bg-warning-subtle', color: '#ffc107' };
      }
      return { text: 'text-danger', bg: 'bg-danger-subtle', color: '#dc3545' };
    },
    sparklinePath() {
      if (this.sensorHistory.length < 2) {
        return "M 0 17 L 100 17";
      }
      // Draw smooth path inside 100x35 box
      const values = this.sensorHistory.map(h => parseFloat(h.ph_level));
      const min = Math.min(...values, 4);
      const max = Math.max(...values, 10);
      const range = max - min || 1;
      
      let points = [];
      const step = 100 / (values.length - 1);
      
      for (let i = 0; i < values.length; i++) {
        const x = i * step;
        // Invert Y since 0 is top
        const y = 30 - ((values[i] - min) / range) * 25;
        points.push(`${x.toFixed(1)},${y.toFixed(1)}`);
      }
      return "M " + points.join(" L ");
    },
    filteredUsuarios() {
      if (!this.searchUsuarios) return this.usuariosList;
      const q = this.searchUsuarios.toLowerCase();
      return this.usuariosList.filter(u => 
        (u.nombre_completo && u.nombre_completo.toLowerCase().includes(q)) ||
        (u.correo_usuario && u.correo_usuario.toLowerCase().includes(q)) ||
        (u.sector_zona && u.sector_zona.toLowerCase().includes(q))
      );
    },
    usuariosFiltradosPago() {
      if (!this.searchUsuarioPago) return this.usuariosList;
      const q = this.searchUsuarioPago.toLowerCase();
      return this.usuariosList.filter(u => 
        (u.id_usuario && u.id_usuario.toString().includes(q)) ||
        (u.nombre_completo && u.nombre_completo.toLowerCase().includes(q)) ||
        (u.correo_usuario && u.correo_usuario.toLowerCase().includes(q))
      );
    },
    filteredReportes() {
      if (!this.searchReportes) return this.reportesList;
      const q = this.searchReportes.toLowerCase();
      return this.reportesList.filter(r => 
        (r.descripcion && r.descripcion.toLowerCase().includes(q)) ||
        (r.sector_manzana_calle && r.sector_manzana_calle.toLowerCase().includes(q)) ||
        (r.categoria_de_problema && r.categoria_de_problema.toLowerCase().includes(q))
      );
    },
    consumoCalculado() {
      const act = parseFloat(this.pagoForm.lectura_actual) || 0;
      const ant = parseFloat(this.pagoForm.lectura_anterior) || 0;
      const diff = act - ant;
      return diff > 0 ? parseFloat(diff.toFixed(2)) : 0;
    },
    costoConsumoCalculado() {
      return parseFloat((this.consumoCalculado * 1.50).toFixed(2));
    },
    saldoPendienteAcumulado() {
      if (!this.pagoForm.id_usuario) return 0;
      const userId = parseInt(this.pagoForm.id_usuario);
      const pendingRecibos = this.pagosList.filter(p => p.id_usuario === userId && p.estado_pago !== 'Pagado');
      const totalPending = pendingRecibos.reduce((sum, p) => sum + parseFloat(p.total_pagar), 0);
      return parseFloat(totalPending.toFixed(2));
    },
    totalPagarCalculado() {
      return parseFloat((this.costoConsumoCalculado + 4.50 + this.saldoPendienteAcumulado).toFixed(2));
    },
    lecturaActualInvalida() {
      if (!this.pagoForm.lectura_actual) return false;
      const act = parseFloat(this.pagoForm.lectura_actual) || 0;
      const ant = parseFloat(this.pagoForm.lectura_anterior) || 0;
      return act < ant;
    },
    filteredPagos() {
      if (!this.searchPagos) return this.pagosList;
      const q = this.searchPagos.toLowerCase();
      return this.pagosList.filter(p => 
        (p.id_usuario && p.id_usuario.toString().includes(q)) ||
        (p.mes_facturado && p.mes_facturado.toLowerCase().includes(q)) ||
        (p.estado_pago && p.estado_pago.toLowerCase().includes(q))
      );
    }
  },
  watch: {
    sensorHistory: {
      handler() {
        this.actualizarGraficos();
      },
      deep: true
    },
    chartPeriod() {
      this.cargarSensorData();
    }
  },
  mounted() {
    this.iniciarFechas();
    this.cargarDatosGenerales();
    
    // Refresh loop every 30 seconds
    this.intervalId = setInterval(() => {
      this.cargarDatosGenerales();
    }, 30000);
  },
  beforeUnmount() {
    if (this.intervalId) clearInterval(this.intervalId);
    if (this.qChartInstance) this.qChartInstance.destroy();
  },
  methods: {
    iniciarFechas() {
      const opciones = { day: 'numeric', month: 'short', year: 'numeric' };
      const hoy = new Date();
      // Format like "22 abr. 2024 - 22 may. 2024" or single date
      const haceUnMes = new Date();
      haceUnMes.setMonth(hoy.getMonth() - 1);
      
      this.fechaActualTexto = haceUnMes.toLocaleDateString('es-ES', opciones) + ' - ' + hoy.toLocaleDateString('es-ES', opciones);
    },
    async cargarDatosGenerales() {
      await this.cargarSensorData();
      await this.cargarAlertas();
      await this.cargarUsuarios();
      await this.cargarReportes();
      await this.cargarActividades();
      await this.cargarPagos();
      
      this.$nextTick(() => {
        this.actualizarQualityChart();
      });
    },
    async cargarSensorData() {
      try {
        const res = await axios.get('/admin/sensor-api');
        if (res.data) {
          this.sensor = res.data.sensor || this.sensor;
          this.sensorForm.ph_level = this.sensor.ph_level;
          this.sensorForm.water_level = this.sensor.water_level;
          
          if (res.data.history) {
            this.sensorHistory = res.data.history.slice(-parseInt(this.chartPeriod));
          }
        }
      } catch (err) {
        console.error("Error fetching sensor readings", err);
      }
    },
    async cargarAlertas() {
      try {
        const res = await axios.get('/admin/alertas-api-list');
        this.alertasList = res.data;
      } catch (err) {
        console.error("Error fetching alerts", err);
      }
    },
    async cargarUsuarios() {
      try {
        const res = await axios.get('/admin/usuarios-api');
        this.usuariosList = res.data;
      } catch (err) {
        console.error("Error fetching users", err);
      }
    },
    async cargarReportes() {
      try {
        const res = await axios.get('/admin/reportes-api-list');
        this.reportesList = res.data;
      } catch (err) {
        console.error("Error fetching reports", err);
      }
    },
    async cargarActividades() {
      try {
        const res = await axios.get('/admin/actividades-api');
        this.activityList = res.data;
      } catch (err) {
        console.error("Error loading system activities", err);
      }
    },
    alertItemClass(tipo) {
      if (tipo === 'red') return 'bg-danger-subtle bg-opacity-25 border-danger';
      if (tipo === 'yellow') return 'bg-warning-subtle bg-opacity-25 border-warning';
      return 'bg-primary-subtle bg-opacity-25 border-primary';
    },
    alertBadgeClass(tipo) {
      if (tipo === 'red') return 'bg-danger text-white';
      if (tipo === 'yellow') return 'bg-warning text-dark';
      return 'bg-primary text-white';
    },
    formatFecha(fecha) {
      if (!fecha) return '';
      const d = new Date(fecha);
      const fechaPart = d.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
      const horaPart = d.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', hour12: true });
      return fechaPart + ' ' + horaPart;
    },
    formatAlertFecha(fechaTexto) {
      if (!fechaTexto) return '';
      if (/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(fechaTexto)) {
        try {
          const d = new Date(fechaTexto.replace(' ', 'T'));
          const opciones = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
          let formatted = d.toLocaleDateString('es-ES', opciones);
          return formatted.charAt(0).toUpperCase() + formatted.slice(1);
        } catch (e) {
          return fechaTexto;
        }
      }
      return fechaTexto;
    },
    activarTab(tabId) {
      const tabTriggerEl = document.querySelector(`#${tabId}-tab-btn`);
      if (tabTriggerEl) {
        tabTriggerEl.click();
      }
    },

    // Administrative Actions
    async actualizarSensores() {
      this.guardandoSensores = true;
      try {
        const res = await axios.post("/admin/debug-sensores-api", this.sensorForm);
        if (res.data && res.data.success) {
          alertify.success('Sensores actualizados exitosamente');
          await this.cargarSensorData();
          await this.cargarActividades();
        } else {
          alertify.error('Error al actualizar sensores');
        }
      } catch (err) {
        alertify.error('Error al conectar con la base de datos');
      } finally {
        this.guardandoSensores = false;
      }
    },
    async crearAlerta() {
      this.guardandoAlerta = true;
      try {
        // Combine date and 12-hour time selection into YYYY-MM-DD HH:mm format
        if (this.alertaForm.fecha_limite && this.alertaForm.hora_12 && this.alertaForm.minutos && this.alertaForm.periodo) {
          let hrs = parseInt(this.alertaForm.hora_12);
          if (this.alertaForm.periodo === 'PM' && hrs < 12) hrs += 12;
          if (this.alertaForm.periodo === 'AM' && hrs === 12) hrs = 0;
          let hrsStr = hrs.toString().padStart(2, '0');
          this.alertaForm.fecha_texto = `${this.alertaForm.fecha_limite} ${hrsStr}:${this.alertaForm.minutos}`;
        }
        
        const res = await axios.post("/admin/alertas-api", this.alertaForm);
        if (res.data && res.data.success) {
          alertify.success('Alerta publicada exitosamente');
          // Reset form
          this.alertaForm.titulo = '';
          this.alertaForm.fecha_limite = '';
          this.alertaForm.hora_12 = '';
          this.alertaForm.minutos = '';
          this.alertaForm.periodo = 'AM';
          this.alertaForm.fecha_texto = '';
          this.alertaForm.zona = '';
          this.alertaForm.motivo = '';
          this.alertaForm.descripcion = '';
          await this.cargarAlertas();
          await this.cargarActividades();
        } else {
          alertify.error('Error al publicar la alerta');
        }
      } catch (err) {
        alertify.error('Error de conexión');
      } finally {
        this.guardandoAlerta = false;
      }
    },
    async borrarAlerta(id) {
      if (!confirm('¿Estás seguro de borrar esta alerta?')) return;
      try {
        const res = await axios.delete(`/admin/alertas-api/${id}`);
        if (res.data && res.data.success) {
          alertify.success('Alerta eliminada del sistema');
          await this.cargarAlertas();
          await this.cargarActividades();
        } else {
          alertify.error('Error al borrar la alerta');
        }
      } catch (err) {
        alertify.error('Error de conexión');
      }
    },
    async actualizarUsuario(u) {
      try {
        const res = await axios.post('/admin/usuarios-rol-api', {
          id_usuario: u.id_usuario,
          rol: u.rol,
          is_active: u.is_active
        });
        if (res.data.success) {
          alertify.success(`Usuario ${u.nombre_completo || u.correo_usuario} actualizado`);
          await this.cargarUsuarios();
          await this.cargarActividades();
        } else {
          alertify.error('Error al actualizar usuario');
        }
      } catch (err) {
        alertify.error('Error de conexión');
      }
    },
    async borrarReporte(id) {
      if (!confirm('¿Deseas marcar este reporte como resuelto y eliminarlo?')) return;
      try {
        const res = await axios.delete(`/admin/reportes-api/${id}`);
        if (res.data.success) {
          alertify.success("Reporte resuelto y eliminado");
          await this.cargarReportes();
          await this.cargarActividades();
        } else {
          alertify.error("Error al archivar reporte");
        }
      } catch (err) {
        alertify.error("Error de conexión");
      }
    },

    // Administrative Billing Methods
    async buscarLecturaAnterior() {
      if (!this.pagoForm.id_usuario) {
        this.pagoForm.lectura_anterior = 0;
        return;
      }
      try {
        const res = await axios.get(`/admin/pagos/ultimo-registro/${this.pagoForm.id_usuario}`);
        if (res.data) {
          this.pagoForm.lectura_anterior = res.data.lectura_actual;
        } else {
          this.pagoForm.lectura_anterior = 0;
        }
      } catch (err) {
        this.pagoForm.lectura_anterior = 0;
      }
    },
    async cargarPagos() {
      try {
        const res = await axios.get('/admin/pagos-api-list');
        this.pagosList = res.data;
      } catch (err) {
        console.error("Error loading payments list", err);
      }
    },
    async crearRecibo() {
      if (this.lecturaActualInvalida) return;
      this.guardandoPago = true;
      try {
        const payload = {
          id_usuario: this.pagoForm.id_usuario,
          fecha_pago: new Date().toISOString().slice(0, 19).replace('T', ' '),
          mes_facturado: `${this.pagoForm.mes} ${this.pagoForm.anio}`,
          lectura_anterior: this.pagoForm.lectura_anterior,
          lectura_actual: this.pagoForm.lectura_actual,
          consumo: this.consumoCalculado,
          total_pagar: this.totalPagarCalculado,
          estado_pago: 'Pendiente'
        };
        const res = await axios.post('/admin/pagos-api', payload);
        if (res.data && res.data.success) {
          alertify.success('Recibo generado exitosamente');
          this.pagoForm.lectura_actual = '';
          this.pagoForm.override = false;
          await this.buscarLecturaAnterior();
          await this.cargarPagos();
          await this.cargarActividades();
          this.ticketReceipt = res.data.data;
        } else {
          alertify.error('Error al generar el recibo');
        }
      } catch (err) {
        alertify.error('Error de conexión con el servidor');
      } finally {
        this.guardandoPago = false;
      }
    },
    async cambiarEstadoPago(pago) {
      const nuevoEstado = pago.estado_pago === 'Pagado' ? 'Pendiente' : 'Pagado';
      try {
        const res = await axios.post('/admin/pagos-api/cambiar-estado', {
          id_pago: pago.id_pago,
          estado_pago: nuevoEstado
        });
        if (res.data && res.data.success) {
          alertify.success(`Estado cambiado a ${nuevoEstado}`);
          await this.cargarPagos();
        } else {
          alertify.error('Error al cambiar estado de pago');
        }
      } catch (err) {
        alertify.error('Error de conexión');
      }
    },
    async borrarPago(id) {
      if (!confirm('¿Estás seguro de anular y borrar este recibo?')) return;
      try {
        const res = await axios.delete(`/admin/pagos-api/${id}`);
        if (res.data && res.data.success) {
          alertify.success('Recibo eliminado correctamente');
          await this.cargarPagos();
          await this.cargarActividades();
        } else {
          alertify.error('Error al borrar recibo');
        }
      } catch (err) {
        alertify.error('Error de conexión');
      }
    },
    imprimirRecibo(pago) {
      this.ticketReceipt = pago;
    },
    printReceiptElement() {
      const printContent = document.getElementById('ticket-print-area').innerHTML;
      const windowUrl = 'about:blank';
      const uniqueName = new Date().getTime();
      const windowName = 'Print' + uniqueName;
      const PrintWindow = window.open(windowUrl, windowName, 'left=500,top=100,width=400,height=600');
      
      PrintWindow.document.write(`
        <html>
          <head>
            <title>Imprimir Recibo - HidroVida</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>
            <style>
              body { font-family: monospace; padding: 20px; color: #000; }
              .border-dashed { border-top: 1px dashed #000; }
              .extra-small { font-size: 0.8rem; }
              .extra-extra-small { font-size: 0.7rem; }
              @media print {
                body { padding: 0; }
                .no-print { display: none; }
              }
            </style>
          </head>
          <body onload="window.print();window.close()">
            <div style="max-width: 300px; margin: 0 auto;">
              ${printContent}
            </div>
          </body>
        </html>
      `);
      PrintWindow.document.close();
      PrintWindow.focus();
    },
 
    // Charts Drawing
    actualizarGraficos() {
      this.actualizarQualityChart();
    },
    actualizarQualityChart() {
      const canvas = document.getElementById('qualityChart');
      if (!canvas) return;

      const labels = this.sensorHistory.map(h => {
        const d = new Date(h.created_at);
        return d.toLocaleDateString([], { day: 'numeric', month: 'short' });
      });
      const data = this.sensorHistory.map(h => parseFloat(h.ph_level));

      if (this.qChartInstance) {
        this.qChartInstance.data.labels = labels;
        this.qChartInstance.data.datasets[0].data = data;
        this.qChartInstance.update();
        return;
      }

      // Draw chart
      try {
        const ctx = canvas.getContext('2d');
        this.qChartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'pH Promedio',
              data: data,
              borderColor: '#299bc4',
              backgroundColor: 'rgba(41, 155, 196, 0.05)',
              borderWidth: 2.5,
              tension: 0.35,
              pointBackgroundColor: '#299bc4',
              pointRadius: 4,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false }
            },
            scales: {
              y: {
                min: 4,
                max: 10,
                grid: {
                  color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                  stepSize: 1
                }
              },
              x: {
                grid: { display: false }
              }
            }
          }
        });
      } catch (err) {
        console.error("Error creating Chart.js quality instance", err);
      }
    }
  }
};
</script>

<style scoped>
.dashboard-container {
  background-color: #f8fafc;
  min-height: 80vh;
  border-radius: 20px;
}

.leading-none {
  line-height: 1;
}

.extra-small {
  font-size: 0.8rem;
}

.extra-extra-small {
  font-size: 0.72rem;
}

.icon-wrapper {
  width: 48px;
  height: 48px;
  flex-shrink: 0;
}

.alert-item {
  border-left-width: 4px;
}

.alert-icon-circle {
  width: 24px;
  height: 24px;
  flex-shrink: 0;
  font-size: 0.8rem;
}

.activity-dot {
  width: 32px;
  height: 32px;
  border-width: 2px;
}

.activity-item pb-3:last-child {
  padding-bottom: 0 !important;
}

/* Customizing tab active styles */
.nav-tabs .nav-link {
  border: none;
  background-color: #f1f5f9;
  color: #64748b !important;
}

.nav-tabs .nav-link:hover {
  background-color: #e2e8f0;
}

.nav-tabs .nav-link.active {
  background-color: #ffffff !important;
  color: #0f172a !important;
  border-bottom: 3px solid #3b82f6 !important;
}

/* Hide scrollbar for alerts list */
.alerts-list::-webkit-scrollbar {
  width: 4px;
}
.alerts-list::-webkit-scrollbar-track {
  background: transparent;
}
.alerts-list::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 4px;
}

/* Custom dashed border for printable receipts */
.border-dashed {
  border-top: 2px dashed #e2e8f0;
}
</style>
