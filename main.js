document.addEventListener("DOMContentLoaded", () => {
    mostrarAlumnos();
    frmAlumnos.addEventListener("submit", (e) => {
        e.preventDefault();
       guardarAlumno();
    });
});

function mostrarAlumnos(){
    let tblAlumnos = document.querySelector("#tblAlumnos");
    let n = localStorage.length;
    tblAlumnos.innerHTML = "";
    let filas = "";
    for(let i = 0; i < n; i++){
        let key = localStorage.key(i);
        if (Number(key)){
        let data = JSON.parse(localStorage.getItem(key));
        if (data != null){
            filas += `
            <tr>
                <td>${data.codigo}</td>
                <td>${data.nombre}</td>
                <td>${data.direccion}</td>
                <td>${data.email}</td>
                <td>${data.telefono}</td>
                <td>
                    <button type="button" class="btn btn-warning">Editar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </td>
            </tr>`;
        }
        }
    }
    tblAlumnos.innerHTML = filas;
}

function guardarAlumno() {
    let datos = {
        id: getId(),
        codigo: txtCodigoAlumno.value,
        nombre: txtnombreAlumno.value,
        direccion: txtDireccionAlumno.value,
        email: txtEmailAlumno.value,
        telefono: txtTelefonoAlumno.value
    }, codigoDuplicado = buscarAlumno(datos.codigo);
    if(codigoDuplicado){
        alert("El codigo del alumno ya existe, "+ codigoDuplicado.nombre);
        return;
    }
    localStorage.setItem( datos.id, JSON.stringify(datos)); 

    mostrarAlumnos();
    limpiarFormulario();
}

function getId(){
    return localStorage.length + 1;
}

function limpiarFormulario(){
    frmAlumnos.reset();
}

function buscarAlumno(codigo=''){
    let n = localStorage.length;
    for(let i = 0; i < n; i++){
        let key = localStorage.key(i);
        let datos = JSON.parse(localStorage.getItem(key));
        if(datos?.codigo && datos.codigo.trim().toUpperCase() == codigo.trim().toUpperCase()){
            return datos;
        }
    }
    return null;
}