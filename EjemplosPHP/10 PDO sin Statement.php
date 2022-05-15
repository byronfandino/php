<?php include 'includes/header.php';

// Conectar a la BD con PDO
$db = new PDO('mysql:host=localhost; dbname=bienes_raices', 'root', '');

// Creamos el query
$query = "SELECT titulo, imagen from propiedades";

// Consultamos la base de datos y ejecutamos de una vez el fetch para asignar el arreglo obtenido a la variable $resultado 
$resultado = $db->query($query)->fetchAll( PDO::FETCH_ASSOC );

// Iterar
foreach($resultado as $propiedad):
    echo $propiedad['titulo'];
    echo "<br>";
    echo $propiedad['imagen'];
    echo "<br>";
endforeach;


include 'includes/footer.php';