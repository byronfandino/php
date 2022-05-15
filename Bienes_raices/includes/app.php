<?php 
// En esta app importamos todos los archivos php necesarios con el fin de realizar 
require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
$db = conectarDB();

use App\ActiveRecord;

ActiveRecord::setDB($db);