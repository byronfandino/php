<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <title>Formulario</title>
</head>
<body>

<?php
    require 'includes/database.php';

    //incluimos la conexión de la base de datos 
    $db = conectardb();

    //Consultar las profesiones para listarlas en el select del formulario
    $profesiones = "SELECT * FROM tblprofesion ORDER BY nombre ASC";
    $resultado = mysqli_query($db, $profesiones);

    //Inicializamos las variables en blanco ya que estas se encuentra en el atributo value del formulario
    $nombre = "";
    $edad = "";
    $email = "";
    $imagen = "";
    $profesionId = "";

    //Creamos un arreglo de errores 
    $errores = [];

    //Verificamos si se activó el método POST
    if ($_SERVER['REQUEST_METHOD']  === 'POST'){

        //Obtenemos los datos entregados por el formulario
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $email = $_POST['email'];
        $imagen = $_POST['imagen'];
        $profesionId = $_POST['profesionId'];

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

        if(!$imagen){
            $errores [] = "No se seleccionó ninguna imagen";
        }

        if(!$profesionId){
            $errores []= "El campo Profesión es obligatorio";
        }

        /*Si no hay errores se procede a guardar el registro en la base de datos
          PERO LA IMAGEN NO SE GUARDARÁ EN EL SERVIDOR, ya que no se ha realizado  
          la verificación del archivo en la superglobal $_FILES[], mientras tanto
          guardaremos el nombre de la imagen en la base de datos */
        if(empty($errores)){

            $query = "INSERT INTO tblcliente ( nombre, edad, email, imagen, profesionId) VALUES (";
            $query .= "'${nombre}', ${edad}, '${email}', '${imagen}', '${profesionId}' )";
            
            //Insertar el resgistro en la base de datos
            $resultado = mysqli_query($db, $query);

            if ($resultado){
                //Redireccionar al usuario
                header('Location: /admin');
            }
        }    
    }
?>

<main>
    <!-- Verificamos si existen el arreglo $errores contiene algún mensaje almacenado -->
    <div class="errores">
        <?php foreach ($errores as $error) : ?>
            <div class="alerta error">
                <p>
                    <?php echo $error; ?>
                </p>
            </div>
        <?php endforeach; ?>            
    </div>

    <!-- Almacenamos cada una de las variables en el  -->
    <form class="formulario" method="POST" action="">
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
            <input type="file" name="imagen" id="imagen">
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

</body>
</html>