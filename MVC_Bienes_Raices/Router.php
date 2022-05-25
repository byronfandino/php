<?php 

namespace MVC;

class Router{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }
    
    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();
        $auth=$_SESSION['login'] ?? null;

        //Arreglo de rutas protegidas
        $rutas_protegidas=[
                            '/admin',
                            '/propiedades/crear', 
                            '/propiedades/actualizar',
                            '/propiedades/eliminar',
                            '/vendedores/crear',                            
                            '/vendedores/actualizar',
                            '/vendedores/eliminar'
                        ];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //PROTEGER LAS RUTAS
        /*in_array permite buscar un elemento dentro de un arreglo
          para evitar un foreach, devolviendo como valor un true o un false*/
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /');
        }

        if($fn){
            //si la variable $fn existe

            /* call_user_func() Nos permite llamar una función cuando no sabemos
               cuando no sabemos como se llama esa función */
            call_user_func($fn, $this);

        }else{
            header('Location: /');
        }
    }

    //Muestra una vista

    public function render($view, $datos = []){

        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start();
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}

?>