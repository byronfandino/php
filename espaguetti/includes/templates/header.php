<?php
    //Se hace esto con el fin de verificar si session_start ya fue iniciada
    if (!isset($_SESSION)){
        //En caso de que PHp no encuentre la superglobal $_SESSION, debemos iniciar sesión
        session_start();
    }

    //Asignamos el valor de la sesión, en caso de que el usuario no haya iniciado sesión asignamos el valor de false
    $auth = $_SESSION['login'] ?? false;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/app.css">
    <title>Software asistencia</title>
</head>
<body>

    <nav>
        <a href="quienes-somos.php">Quienes somos</a>
        <a href="contactenos.php">Contactenos</a>
        <?php  if ($auth) : ?>
            <a href="cerrar-sesion.php">Cerrar sesión</a>
        <?php endif; ?>    
    </nav>