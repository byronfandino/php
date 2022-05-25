<?php

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id','nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    
    public function validar(){
        
        if(!$this->nombre){
            self::$errores[]="El nombre es obligatorio";
        }
        if(!$this->apellido){
            self::$errores[]="El apellido es obligatorio";
        }
        if(!$this->telefono){
            self::$errores[]="El telefono es obligatorio";
        }

        //Utilizamos una expresión regular para buscar un patrón dentro de un texto
        /*En esta expresión indicamos que en la propiedad teléfono se debe
           cumplir los requisitos en el que cada caracter debe estar entre 0 y 9 y que
           forzadamente debe tener 10 digitos.
        */
        if(!preg_match('/[0-9]{10}/',$this->telefono)){
            self::$errores[]="Formato de teléfono NO VALIDO";
        }

        return self::$errores;
    }
}

?>