<?php


    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedor;

    // Importar Intervention Image
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Consultar para obtener los vendedores
    $vendedores = Vendedor::all();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // En el formulario donde se obtienen los datos por parte del usuario final, cada uno de los campos se asignó en el name de propiedad[nombreCampo], de tal manera que obtenemos un arreglo cuyo primer elemento se llama propiedad, por lo tanto, asignamos ese primer arreglo asociativo a la variable $args
        $args = $_POST['propiedad'];

        //Se debe sincronizar porque ya se había creado un objeto al momento de buscar el id del registro y por lo tanto es necesario actualizar los datos escritos en el formulario por parte del usuario al objeto que ya estaba creadoo para guardar posteriormente los datos del objeto en la base de datos 
        $propiedad->sincronizar($args);

        // Con el objeto actualizado realizamos la validación
        $errores = $propiedad->validar();

        // Subida de archivos
        // Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        
        if(empty($errores)) {
            // Almacenar la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();
        }
    }
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
        
    </main>

<?php 
    incluirTemplate('footer');
?> 