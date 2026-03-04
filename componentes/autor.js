const autor = {
    props:['forms'],
    data(){
        return{
            autor:{
                idAutor:0,
                codigo:"",
                nombre:"",
                pais:"",
                telefono:""
            },
            accion:'nuevo',
            idAutor:0,
            data_autor:[]
        }
    },
    methods:{
        buscarAutor(){
            this.forms.busqueda_autor.mostrar = !this.forms.busqueda_autor.mostrar;
            this.$emit('buscar');
        },
        modificarAutor(autor){
            this.accion = 'modificar';
            this.idAutor = autor.idAutor;
            this.autor.codigo = autor.codigo;
            this.autor.nombre = autor.nombre;
            this.autor.pais = autor.pais;
            this.autor.telefono = autor.telefono;
        },
        async guardarAutor() {
            let datos = {
                idAutor: this.accion=='modificar' ? this.idAutor : this.getId(),
                codigo: this.autor.codigo,
                nombre: this.autor.nombre,
                pais: this.autor.pais,
                telefono: this.autor.telefono
            };

            // Validar existencia de codigo si es nuevo
            let existe = await db.autor.where('codigo').equals(this.autor.codigo).toArray();
            if(existe.length > 0 && this.accion=='nuevo'){
                alertify.error(`El codigo del autor ya existe: ${existe[0].nombre}`);
                return;
            }

            await db.autor.put(datos);
            this.limpiarFormulario();
            alertify.success(`${datos.nombre} guardado correctamente`);
        },
        getId(){
            return new Date().getTime();
        },
        limpiarFormulario(){
            this.accion = 'nuevo';
            this.idAutor = 0;
            this.autor.codigo = '';
            this.autor.nombre = '';
            this.autor.pais = '';
            this.autor.telefono = '';
        },
    },
    template: `
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-8">
                <form id="frmAutor" @submit.prevent="guardarAutor" @reset.prevent="limpiarFormulario">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>REGISTRO DE AUTOR</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">CÓDIGO:</label>
                                <div class="col-sm-9">
                                    <input placeholder="Asigne un codigo al autor" required v-model="autor.codigo" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">NOMBRE:</label>
                                <div class="col-sm-9">
                                    <input placeholder="Nombre completo" required v-model="autor.nombre" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">PAÍS:</label>
                                <div class="col-sm-9">
                                    <input placeholder="País de origen" required v-model="autor.pais" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">TELÉFONO:</label>
                                <div class="col-sm-9">
                                    <input placeholder="Número telefónico" required v-model="autor.telefono" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3">
                            <div class="d-flex justify-content-center gap-3">
                                <button type="submit" id="btnGuardarAutor" class="btn btn-primary btn-lg px-4 shadow-sm">GUARDAR</button>
                                <button type="reset" id="btnCancelarAutor" class="btn btn-warning btn-lg px-4 shadow-sm text-white">NUEVO</button>
                                <button type="button" @click="buscarAutor" id="btnBuscarAutor" class="btn btn-success btn-lg px-4 shadow-sm">BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `
};
