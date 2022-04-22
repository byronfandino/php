<?php

    function conectardb() : mysqli{

        $db = mysqli_connect('localhost', 'root', '', 'bdprueba');
        $db->set_charset("utf8");

        if(!$db){
            echo "Error de conexión a la base de datos";
            exit;
        }

        return $db;
    }


?>