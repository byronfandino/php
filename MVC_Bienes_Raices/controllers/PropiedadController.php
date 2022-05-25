<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router){

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        //Para no crear una nueva instancia se realiza de la siguiente manera
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        //Ejecutar el código después de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            /* Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);

            /*-- SUBIDAS DE ARCHIVOS --*/
            //Generar un nombre de la imagen único
            $nombreImagen=md5( uniqid( rand(), true ) ) . ".jpg";

            //Verificamos si se adjunto algún archivo
            if($_FILES['propiedad']['tmp_name']['imagen']){
                //Setear la imagen
                //Realiza un rezise a la imagen con intervention
                $image= Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            
            //Validar si existen errores en alguno de los campos
            $errores = $propiedad->validar();

            if(empty($errores)){

                //Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
                
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                //Guarda en la base de datos            
               $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){

        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //asignar los atributos
            $args = $_POST['propiedad'];
    
            $propiedad->sincronizar($args);
    
            //Validación
            $errores = $propiedad->validar();
    
            //Subida de archivos
            //Generar un nombre de la imagen único
            $nombreImagen=md5( uniqid( rand(), true ) ) . ".jpg";
            
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image= Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            if(empty($errores)){
    
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                //Guarda o Actualiza el registro dependiendo si existe o no un id
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id){
    
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)){
                    
                    $propiedad = propiedad::find($id);
                    $propiedad->eliminar();
    
                }
            }
        }
    }
}


?>