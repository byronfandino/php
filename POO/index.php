<?php

//1. Creamos una función para que detecte el nombre de la clase
function mi_autoload($clase){
    require __DIR__ . '/class/' . $clase . '.php';
}

//2. Utilizamos la función de PHP para cargar las clases de forma automática
spl_autoload_register('mi_autoload');

$detalles = new Detalles();
echo "<br>";
$clientes = new Cliente();

?>