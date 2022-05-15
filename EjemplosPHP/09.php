<?php include 'includes/header.php';

// Conectar a la BD con Mysqli.
$db = new mysqli('localhost', 'root', '', 'bienes_raices');

// Creamos el query
$query = "SELECT titulo, imagen from propiedades";

//Preparamos el statement el cual contendrá toda la información
$stmt = $db->prepare($query);

// Ejecutamos la consulta
$stmt->execute();

// Creamos la(s) variable(s) en las que se guardarán los resultados de los campos de la consulta SQL
$stmt->bind_result($titulo, $imagen);

// Asignamos el resultado con 
while($stmt->fetch()):
    var_dump($titulo);
    echo "<br>";
    var_dump($imagen);
    echo "<br><br>";
endwhile;

include 'includes/footer.php';