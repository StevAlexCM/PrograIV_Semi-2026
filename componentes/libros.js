const libros = {
    props:['forms'],
    data(){
        return{
            libro:{
                idLibro:0,
                idAutor:"",
                isbn:"",
                titulo:"",
                editorial:"",
                edicion:""
            },
            accion:'nuevo',
            idLibro:0,
            data_libros:[],
            autores:[]
        }
    },
    methods:{
        buscarLibro(){
            this.forms.busqueda_libros.mostrar = !this.forms.busqueda_libros.mostrar;
            this.$emit('buscar');
        },
        modificarLibro(libro){
            this.accion = 'modificar';
            this.idLibro = libro.idLibro;
            this.libro.idAutor = libro.idAutor;
            this.libro.isbn = libro.isbn;
            this.libro.titulo = libro.titulo;
            this.libro.editorial = libro.editorial;
            this.libro.edicion = libro.edicion;
        },
        async guardarLibro() {
            let datos = {
                idLibro: this.accion=='modificar' ? this.idLibro : this.getId(),
                idAutor: this.libro.idAutor,
                isbn: this.libro.isbn,
                titulo: this.libro.titulo,
                editorial: this.libro.editorial,
                edicion: this.libro.edicion
            };

            let existe = await db.libros.where('isbn').equals(this.libro.isbn).toArray();
            if(existe.length > 0 && this.accion=='nuevo'){
                alertify.error(`El ISBN del libro ya existe: ${existe[0].titulo}`);
                return;
            }

            await db.libros.put(datos);
            this.limpiarFormulario();
            alertify.success(`${datos.titulo} guardado correctamente`);
        },
        getId(){
            return new Date().getTime();
        },
        limpiarFormulario(){
            this.accion = 'nuevo';
            this.idLibro = 0;
            this.libro.idAutor = '';
            this.libro.isbn = '';
            this.libro.titulo = '';
            this.libro.editorial = '';
            this.libro.edicion = '';
        },
        async obtenerAutores(){
            this.autores = await db.autor.toArray();
        }
    },
    mounted(){
        this.obtenerAutores();
    },
    template: `
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-11 col-lg-9">
                <form id="frmLibros" @submit.prevent="guardarLibro" @reset.prevent="limpiarFormulario">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h5 class="mb-0"><i class="bi bi-book-half me-2"></i>REGISTRO DE LIBROS</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">ISBN (Código):</label>
                                <div class="col-sm-9">
                                    <input placeholder="Ingrese el ISBN del libro" required v-model="libro.isbn" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">TÍTULO:</label>
                                <div class="col-sm-9">
                                    <input placeholder="Título del libro" required v-model="libro.titulo" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">AUTOR:</label>
                                <div class="col-sm-9">
                                    <select required v-model="libro.idAutor" class="form-select form-select-lg" @click="obtenerAutores()">
                                        <option value="" disabled selected>-- Seleccione un autor --</option>
                                        <option v-for="aut in autores" :key="aut.idAutor" :value="aut.idAutor">
                                            {{aut.nombre}} ({{aut.codigo}})
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">EDITORIAL:</label>
                                <div class="col-sm-9">
                                    <input placeholder="Nombre de la editorial" required v-model="libro.editorial" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">EDICIÓN:</label>
                                <div class="col-sm-9">
                                    <input placeholder=" Coloque que edicion es" required v-model="libro.edicion" type="text" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3">
                            <div class="d-flex justify-content-center gap-3">
                                <button type="submit" id="btnGuardarLibro" class="btn btn-primary btn-lg px-4 shadow-sm">GUARDAR</button>
                                <button type="reset" id="btnCancelarLibro" class="btn btn-warning btn-lg px-4 shadow-sm text-white">NUEVO</button>
                                <button type="button" @click="buscarLibro" id="btnBuscarLibro" class="btn btn-success btn-lg px-4 shadow-sm">BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `
};
