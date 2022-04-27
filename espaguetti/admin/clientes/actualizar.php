<?php
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    include __DIR__ . '/../../includes/encabezado.php';

    //incluimos la conexión de la base de datos 
    $db = conectardb();

    //Obtener los datos del cliente
    //Escribir el Query
    $query = "SELECT cl.id, cl.nombre, cl.edad, cl.email, cl.imagen, cl.profesionId, p.id as 'idprofesion', p.nombre as 'profesion' ";
    $query .= " FROM tblcliente as cl, tblprofesion as p ";
    $query .= " WHERE cl.profesionId=p.id ";
    $query .= " AND cl.id=${id} ";
    $resultado = mysqli_query($db, $query);
    $cliente=mysqli_fetch_assoc($resultado);

    //Obtener los datos de las profesiones para listarlas en el SELECT
    $profesiones = "SELECT * FROM tblprofesion ORDER BY nombre ASC";
    $resultado = mysqli_query($db, $profesiones);

    //Inicializamos las variables con los datos que debe cargar el formulario
    $nombre = $cliente['nombre'];
    $edad = $cliente['edad'];
    $email = $cliente['email'];
    $imagen = $cliente['imagen'];
    $profesionId = $cliente['profesionId'];

    //Creamos un arreglo de errores 
    $errores = [];

    //Verificamos si se activó el método POST
    if ($_SERVER['REQUEST_METHOD']  === 'POST'){

        //Obtenemos los datos entregados por el formulario
        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $edad = mysqli_real_escape_string($db, $_POST['edad']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $imagen = $_FILES['imagen'];
        $profesionId = mysqli_real_escape_string($db, $_POST['profesionId']);

        //Verificamos si se diligenció cada uno de los campos
        if(!$nombre){
            $errores []= "El campo Nombre es obligatorio";
        }

        if(!$edad){
            $errores [] = "El campo Edad es obligatorio";
        }

        if (!$email){
            $errores [] = "El campo Email es obligatorio";
        }

        if(!$profesionId){
            $errores []= "El campo Profesión es obligatorio";
        }
        
        if(!$imagen['name']){
            $errores [] = "La imagen es obligatoria";
        }

        // Validar si la imagen fue seleccionada
        if($imagen['error']){
            $errores[] = "La imagen no se cargó";
        }

        // Validar por tamaño si es mayor a 100 KB
        if($imagen['size']  > 1000000){
            $errores[] = "La imagen es muy pesada";
        }

        /*Si no hay errores se procede a subir el archivo 
         al servidor y guardar el registro en la base de datos*/
        if(empty($errores)){

            /*SUBIDA DE ARCHIVOS */
            //Crear una carpeta
            $carpetaImagenes = '../../imagenes';

            //Si no existe la carpeta imagenes se debe crear
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Crear un nombre único 
            $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

            //Una vez creada la carpeta, movemos el archivo que quedó en memoria y lo pasamos a la carpeta destinada en el servidor
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . '/' . $nombreImagen);
            //NOTA: Al mover un mismo archivo con el mismo nombre 2 veces se reemplaza el archivo en la carpeta imagenes

            //Preparamos la sentencia SQL para insertarlo en la base de datos.
            $query = "INSERT INTO tblcliente ( nombre, edad, email, imagen, profesionId) VALUES (";
            $query .= "'${nombre}', ${edad}, '${email}', '${nombreImagen}', ${profesionId} )";
            
            //Insertar el resgistro en la base de datos
            $resultado = mysqli_query($db, $query);

            if ($resultado){
                //Redireccionar al usuario cuando el registro se guarda exitosamente
                header('Location: /admin?resultado=1');
            }
        }    
    }
?>

<main class="main-cc">
    <h1>Actualizar Cliente</h1>
    <!-- Verificamos si existen el arreglo $errores contiene algún mensaje almacenado -->
    <div class="notificacion">
        <?php foreach ($errores as $error) : ?>
            <div class="alerta error">
                <p>
                    <?php echo $error; ?>
                </p>
            </div>
        <?php endforeach; ?>            
    </div>

    <!-- Almacenamos cada una de las variables en el  -->
    <form class="formulario" method="POST" action="" enctype="multipart/form-data">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="campo">
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" value="<?php echo $edad; ?>">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>">
        </div>
        <div class="campo">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">
        </div>
        <div class="campo">
            <figure>
                <img src="../../imagenes/<?php echo $imagen; ?>" alt="">
            </figure>
        </div>
        <div class="campo">
            <label for="profesionId">Profesión</label>
            <select name="profesionId" id="profesionId">

                <option value="">-- Seleccione una opción--</option>
                
                <?php while($profesion = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $profesion['id'] === $profesionId ? 'selected' : ''; ?>
                        value="<?php echo $profesion['id']; ?>"> 
                            <?php echo $profesion['nombre']; ?> 
                    </option>
                <?php endwhile; ?>

            </select>
        </div>

        <input type="submit" value="Enviar">

    </form>
        
</main>

<?php
    include '../../includes/templates/footer.php';
?>