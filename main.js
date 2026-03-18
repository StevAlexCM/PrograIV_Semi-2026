const { createApp } = Vue,
    Dexie = window.Dexie,
    db = new Dexie("db_academica"),
    sha256 = CryptoJS.SHA256;


createApp({
    components:{
        alumnos,
        busqueda_alumnos,
        materias,
        busqueda_materias,
        docentes,
        busqueda_docentes,
        inscripciones,
        busqueda_inscripciones,
        matriculas,
        busqueda_matriculas
    },
    data(){
        return{
            forms:{
                alumnos:{mostrar:false},
                busqueda_alumnos:{mostrar:false},
                materias:{mostrar:false},
                busqueda_materias:{mostrar:false},
                docentes:{mostrar:false},
                busqueda_docentes:{mostrar:false},
                matriculas:{mostrar:false},
                busqueda_matriculas:{mostrar:false},
                inscripciones:{mostrar:false},
                busqueda_inscripciones:{mostrar:false}
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
        db.version(2).stores({
            "alumnos": "idAlumno, codigo, nombre, direccion, email, telefono",
            "materias": "idMateria, codigo, nombre, uv",
            "docentes": "idDocente, codigo, nombre, direccion, email, telefono, escalafon",
            "inscripciones": "idInscripciones, codigo_alumno, nombre_alumno, codigo_materia, nombre_materia, uv, fecha_inscripcion, ciclo_periodo, estado, observaciones",
            "matriculas": "idMatricula, codigo_alumno, nombre_alumno, fecha, ciclo, estado"
        });
    }
}).mount("#app");
