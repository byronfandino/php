<?php

//Importar la conexión
include 'includes/encabezado.php';
$db = conectardb();

$errores = [];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    
    //Como los datos se obtienen de lo que digita el usuario debemos aplicar los filtros de validación de email y de mysqli para la eliminación de caracteres de alguna inyección SQL
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email){
        $errores[] = "El email es obligatorio";
    }
    
    if (!$password){
        $errores[] = "El password es obligatorio";
    }

    if(empty($errores)){

        //SQL para revisar si el usuario existe
        $query = "SELECT * FROM tblusuario WHERE email = '${email}' LIMIT 1";
        $resultado = mysqli_query($db, $query);

        $usuario = mysqli_fetch_assoc($resultado);

        //Verificamos si el password hasheado en la base de datos corresponde al pasword digitado por el usuario
        $auth = password_verify($password, $usuario['password']);

        if($auth){

            //Si el usuario está autenticado asignamos las 
            session_start();

            //Llenar el arreglo de session_start()
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['login'] = true;

            header('Location: /admin');

        }else{
            $errores[] = "El email y/o password es incorrecto";
        }
        
        //---Empieza la revisión----
        ?>
        <div class='revisar'>
        <pre>
        <?php var_dump($resultado); ?>
        </pre>
        <?php
        exit;
        //Termina la revisión
        //Verificación de base de datos
        
        //

    }
}

?>
<main class="main-cc">
    <h1>Iniciar sesión</h1>

    <div class="notificacion">
        <?php foreach ($errores as $error) : ?>
            <div class="alerta error">
                <p> <?php echo $error; ?> </p>
            </div>
        <?php endforeach; ?>            
    </div>

    <form method="POST" class="formulario">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>
        <div class="campo">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Iniciar sesión" class="boton boton-azul">
    </form>
</main>

<?php
    include 'includes/templates/footer.php';
?>