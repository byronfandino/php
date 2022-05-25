<?php
    namespace Model;


    class Admin extends ActiveRecord{
        
        //Base de datos
        protected static $tabla = 'usuarios';
        protected static $columnasDB = ['id', 'email', 'password'];

        public $id;
        public $email;
        public $password;

        public function __construct($args = [] )
        {
            $this->id = $args['id'] ?? null;
            $this->email = $args['email'] ?? '';
            $this->password = $args['password'] ?? '';
        }

        public function validar(){
            
            if($this->email === ''){
                self::$errores[] = 'El email es obligatorio';
            }

            if($this->password === ''){
                self::$errores[] = 'El password es obligatorio';
            }
            return self::$errores;
        }

        public function existeUsuario(){
            
            $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";
            $resultado = self::$db->query($query);

            if(!$resultado->num_rows){
                self::$errores [] = "El email no existe";
                /*Se coloca return para que el código deje de ejecutarse
                  no obstante el valor que retorna 
                  es NULL */
                return;
            }
            
            //En caso de que si exista el registro entonces retornamos el resultado
            return $resultado;
        }

        public function comprobarPassword($resultado){
            /* fetch_object trae el resultado de lo que se haya encontrado en la base de datos,
               de igual manera no podemos revisar el contenido con debugguear por lo tanto también es
               necesario utilizar el fetch_object para conocer el contenido obtenido de la base de datos  */
            $usuario = $resultado->fetch_object();

            /*password_verify permite comparar 2 password
              el primero es el password a comparar (ya que no tiene ninguna encriptación)y 
              el segundo parámetro es el password que almacenado en la base de datos para 
              lo cual devuelve True o False (este si tiene encriptación)
              por eso se utiliza password_verify porque realiza la comparación de dos password 
              sin necesidad de encriptar el escrito por el usuario ya que internamente realiza el 
              procedimiento para realizar esta comparación*/
              
            $autenticado = password_verify($this->password, $usuario->password);

            if(!$autenticado){
                self::$errores [] = "El password es incorrecto";
            }

            return $autenticado;
        }

        public function autenticar(){
            //iniciamos la sesión
            session_start();

            //llenamos el arreglo de sesión
            $_SESSION['usuario'] = $this->email;
            $_SESSION['login'] = true;

            header('Location: /admin');
        }
    }

?>
