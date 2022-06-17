window.onload = lanzadera;

function lanzadera() {
    iniciar();
    efectos();
}
// Dependiendo del boton clicado se ejecutara una funcion de validar u otra
function iniciar() {
    if (document.getElementById("registrarse") != null) {
        document.getElementById("registrarse").addEventListener('click', validarRegistro, false);
    }

    if (document.getElementById("iniciar") != null) {
        document.getElementById("iniciar").addEventListener('click', validarInicio, false);
    }

    if (document.getElementById("contacto") != null) {
        document.getElementById("contacto").addEventListener('click', validarContacto, false);
    }

    if (document.getElementById("producto") != null) {
        document.getElementById("producto").addEventListener('click', validarProducto, false);
    }

    if (document.getElementById("recuperar") != null) {
        document.getElementById("recuperar").addEventListener('click', validarRecuperar, false);
    }

}

// Funciones de validar los formularios segun el boton clicado con sus respectivas funciones de validar los campos necesarios
function validarRegistro(e) {
    if (validaUsuario() && validaNombre() && validaApellidos() && validaEmail() && validaPassword() && coincidenPasswords()) {
        return true
    } else {
        e.preventDefault();
        return false
    }
}

function validarInicio(e) {
    if (validaEmail() && validaPassword()) {
        return true
    } else {
        e.preventDefault();
        return false
    }
}

function validarContacto(e) {
    if (validaNombre() && validaEmail() && validaAsunto() && validaMensaje()) {
        return true
    } else {
        e.preventDefault();
        return false
    }
}

function validarProducto(e) {
    if (validaNombre() && validaMensaje() && validaPrecio()) {
        return true
    } else {
        e.preventDefault();
        return false
    }
}

function validarRecuperar(e) {
    if (validaEmail()) {
        return true
    } else {
        e.preventDefault();
        return false
    }
}


// Funciones de validar los campos con sus respectivas expresiones regulares
function validaUsuario() {
    var elemento = document.getElementById("usuario");
    if (/^\w{2,50}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaNombre() {
    var elemento = document.getElementById("nombre");
    if (/^[a-zA-Z ]{2,50}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaApellidos() {
    var elemento = document.getElementById("apellidos");
    if (/^[a-zA-Z ]{2,50}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaEmail() {
    var elemento = document.getElementById("email");
    if (/^[a-z0-9_]+@[a-z]+\.[a-z]+$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaPassword() {
    var elemento = document.getElementById("password");
    if (/^.{4,50}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaAsunto() {
    var elemento = document.getElementById("asunto");
    if (/^[a-zA-Z ]{4,50}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaMensaje() {
    var elemento = document.getElementById("mensaje");
    if (/^[^$%&|<>#]{4,200}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

function validaPrecio() {
    var elemento = document.getElementById("precio");
    if (/^\d{1,3}.{1}\d{2}$/.test(elemento.value)) {
        borrarError(elemento);
        return true;
    } else {
        error(elemento);
        return false;
    }
}

// Funcion para comprobar que las dos contraseñas introducidas son iguales
function coincidenPasswords() {
    var elemento = document.getElementById("password");
    var elemento2 = document.getElementById("password2");
    if (elemento.value === elemento2.value) {
        borrarError(elemento2);
        return true;
    } else {
        error(elemento2);
        return false;
    }
}

// Funciones de error para cambiar la clase del input y ver u ocultar el mensaje de error
function error(elemento) {
    elemento.classList.add('is-invalid');
    // Para llegar al elemento p, selecionamos al padre del input y luego el indice donde se encuentra el p
    elemento.parentNode.childNodes[5].classList.replace('ocultar-mensaje-error', 'ver-mensaje-error');
    elemento.focus();
}

function borrarError(elemento) {
    elemento.classList.remove('is-invalid');
    elemento.parentNode.childNodes[5].classList.replace('ver-mensaje-error', 'ocultar-mensaje-error');
}

// Funcion para efectos de css
function efectos() {
    $(".imagen-con-efecto").css("display", "none");
    // $(".card-img-top").fadeIn(2500);
    var tiempo = 1400;
    var j = 1;

    $(".imagen-con-efecto").first().fadeIn(tiempo, "swing", siguiente);

    function siguiente() {
        if (j < 3) {
            tiempo -= 300
            $(this).next().fadeIn(tiempo, "swing", siguiente);
            j++;
        }
    }
    $(".col-md-3").css("display", "none");
    $(".col-md-3").fadeIn(1500, "swing");

    $(".centrado-absoluto").css("display", "none");
    $(".centrado-absoluto").fadeIn(2500, "swing");
};