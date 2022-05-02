<?php

//Iniciamos la sesión
session_start();

//Le asignamos a la superglobarl $_SESSION un arreglo vacío
$_SESSION = [];

//Redireccionamos a la pagina index
header('Location: /');
?>