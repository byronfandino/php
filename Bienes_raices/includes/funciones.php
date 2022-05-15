<?php

//Definimos las rutas que se almacenarán en las constantes
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function incluirTemplate( string  $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/${nombre}.php"; 
}

//Función para verificar si el usuario está autenticado, en caso de no estarlo se redirecciona al usuario a la pagina principal
function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    }
}

//Función para verificar el contenido de una variable
function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}


// Valida tipo de petición
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

// Muestra los mensajes de notificación
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Propiedad Creada Correctamente';
            break;
        case 2:
            $mensaje = 'Propiedad Actualizada Correctamente';
            break;
        case 3:
            $mensaje = 'Propiedad Eliminada Correctamente';
            break;
        case 4:
            $mensaje = 'Vendedor Registrado Correctamente';
            break;
        case 5:
            $mensaje = 'Vendedor Actualizado Correctamente';
            break;
        case 6:
            $mensaje = 'Vendedor Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

