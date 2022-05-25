<?php 
    //Verificamos si la sesión ya fue iniciada
    if(!isset($_SESSION)){
        session_start();
    }

    //En caso de que la variable $_SESSION['login'] No exista se asigna el valor de FALSE
    //con el fin de crear el enlace  de "Cerrar sesión"
    $auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Bienes Raíces</title>
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raíces">
                </a>
                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="Imagen de menú responsive">
                </div>

                <div class="derecha">
                    <img src="/build/img/dark-mode.svg" alt="Imagen de DarkMode" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if($auth) : ?>
                            <a href="cerrar-sesion.php">Cerrar sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div> <!-- Cierre de la Barra -->

            <?php
                echo  $inicio ? "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>" : "";
            ?>
        </div>
    </header>