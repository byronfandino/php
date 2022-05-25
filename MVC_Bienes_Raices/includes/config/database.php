<?php

function conectarDB() : mysqli{
    $db = new mysqli('localhost', 'root', '', 'bienes_raices');

    if(!$db){
        echo "ERROR no se pudo conectar";
        exit;
    }

    return $db;
}