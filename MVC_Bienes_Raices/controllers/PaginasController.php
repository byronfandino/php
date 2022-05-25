<?php


namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{

    public static function index(Router $router){
        
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router){
        $router->render('/paginas/nosotros');
    }

    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();
        $router->render('/paginas/propiedades',[
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router){
        
        $id = validarORedireccionar('/propiedades');

        $propiedad = Propiedad::find($id);
        
        $router->render('/paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router){
        $router->render('/paginas/blog');
    }

    public static function entrada(Router $router){
        $router->render('/paginas/entrada');
    }

    public static function contacto(Router $router){

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $respuestas = $_POST['contacto'] ; 
            //Crear una nueva instancia
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'feb872ea15d262';
            $mail->Password = '74308a06b3cb6a';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525; 
            

            //Configurar el contenido el email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com'. 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: '.$respuestas['nombre'].'</p>';
            if ($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Prefiere ser contactado por: '.$respuestas['contacto'].'</p>';
                $contenido .= '<p>Teléfono: '.$respuestas['telefono'].'</p>';
                $contenido .= '<p>Fecha Contacto: '.$respuestas['fecha'].'</p>';
                $contenido .= '<p>Hora: '.$respuestas['hora'].'</p>';
            }else{
                $contenido .= '<p>Prefiere ser contactado por: '.$respuestas['contacto'].'</p>';
                $contenido .= '<p>Email: '.$respuestas['email'].'</p>';
            }
            $contenido .= '<p>Mensaje: '.$respuestas['mensaje'].'</p>';
            $contenido .= '<p>Vende o Compra: '.$respuestas['tipo'].'</p>';
            $contenido .= '<p>Precio o Presupuesto: $'.$respuestas['precio'].'</p>';
            $contenido .= '</html>'; 

            $mail->Body = $contenido;
            $mail->AltBody = $_POST['contacto']['mensaje'];

            //Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }

        $router->render('/paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }

}

?>