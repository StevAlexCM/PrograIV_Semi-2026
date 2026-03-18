const { createApp } = Vue,
    Dexie = window.Dexie,
<<<<<<< HEAD
    db = new Dexie("db_academica"),
    sha256 = CryptoJS.SHA256;
=======
    db = new Dexie("db_codigo_estudiante");
    sha256 = window.sha256;
>>>>>>> c6c844af26937e1be1f61fb2446314191c1ccebd


createApp({
    components:{
<<<<<<< HEAD
        alumnos,
        busqueda_alumnos,
        materias,
        busqueda_materias,
        docentes,
        busqueda_docentes
=======
        autor,
        busqueda_autor,
        libros,
        busqueda_libros
>>>>>>> c6c844af26937e1be1f61fb2446314191c1ccebd
    },
    data(){
        return{
            forms:{
<<<<<<< HEAD
                alumnos:{mostrar:false},
                busqueda_alumnos:{mostrar:false},
                materias:{mostrar:false},
                busqueda_materias:{mostrar:false},
                docentes:{mostrar:false},
                busqueda_docentes:{mostrar:false},
                matriculas:{mostrar:false},
                inscripciones:{mostrar:false}
=======
                autor:{mostrar:false},
                busqueda_autor:{mostrar:false},
                libros:{mostrar:false},
                busqueda_libros:{mostrar:false}
>>>>>>> c6c844af26937e1be1f61fb2446314191c1ccebd
            }
        }
    },
    methods:{
        buscar(ventana, metodo){
            this.$refs[ventana][metodo]();
        },
        abrirVentana(ventana){
            this.forms[ventana].mostrar = !this.forms[ventana].mostrar;
        },
        modificar(ventana, metodo, data){
            this.$refs[ventana][metodo](data);
        }
    },
    mounted(){
        db.version(1).stores({
<<<<<<< HEAD
            "alumnos": "idAlumno, codigo, nombre, direccion, email, telefono",
            "materias": "idMateria, codigo, nombre, uv",
            "docentes": "idDocente, codigo, nombre, direccion, email, telefono, escalafon"
=======
            "autor": "idAutor, codigo, nombre, pais, telefono",
            "libros": "idLibro, idAutor, isbn, titulo, editorial, edicion"
>>>>>>> c6c844af26937e1be1f61fb2446314191c1ccebd
        });
    }
}).mount("#app");
