<?php
    //En el encabezado está la conexión a la base de datos
    include '../includes/encabezado.php';
    $db = conectardb();

    //Escribir el Query
    $query = "SELECT cl.id, cl.nombre, cl.edad, cl.email, cl.imagen, cl.profesionId, p.nombre as 'profesion' ";
    $query .= " FROM tblcliente as cl, tblprofesion as p ";
    $query .= " WHERE cl.profesionId=p.id ";
    
    //Consultar la BD
    $consulta = mysqli_query($db, $query);

    //Verificamos si existe la variable resultado
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $id = $_POST['id'];
        //Siembre hay que realizar la validación de entero para evitar injección SQL
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            //Eliminar el archivo 
            $query = "SELECT imagen FROM tblcliente WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);
            
            $cliente = mysqli_fetch_assoc($resultado);

            unlink('../imagenes/' . $cliente['imagen']);


            //Eliminar la propiedad
            $query = "DELETE FROM tblcliente WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);

            if ($resultado){
                header ('Location: /admin?resultado=3');
            }
        }
    }
?>

<main class="main-ct">

    <h1>Administrador</h1>
    
    <?php if (intval($resultado) === 1) : ?>
            <div class="notificacion">
                <div class="alerta exito">
                    <p> <?php echo "Registro creado correctamente"; ?> </p>
                </div>
            </div>
    <?php elseif (intval($resultado) === 2) : ?>
        <div class="notificacion">
            <div class="alerta exito">
                <p> <?php echo "Registro actualizado correctamente"; ?> </p>
            </div>
        </div>
    <?php elseif (intval($resultado) === 3) : ?>
        <div class="notificacion">
            <div class="alerta exito">
                <p> <?php echo "Registro eliminado correctamente"; ?> </p>
            </div>
        </div>
    <?php endif; ?>

    <div class="navegacion">
        <a href="/admin/clientes/crear.php" class="boton boton-verde">Nuevo cliente</a>
    </div>

    <table class="tablaClientes">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Email</th>
                <th>Imagen</th>
                <th>Profesion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php while($registro = mysqli_fetch_assoc($consulta)): ?>
                
            <tr>
                <td><?php echo $registro['id']; ?></td>
                <td><?php echo $registro['nombre']; ?></td>
                <td><?php echo $registro['edad']; ?></td>
                <td><?php echo $registro['email']; ?></td>
                <td><img src="../imagenes/<?php echo $registro['imagen']; ?>" alt="" class="imagen-tabla"></td>
                <td><?php echo $registro['profesion']; ?></td>
                <td>
                    <a href="admin/clientes/actualizar.php?id=<?php echo $registro['id']; ?>" class="boton boton-amarillo-block">Actualizar</a>
                    
                    <form method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                        <input type="submit" value="Eliminar" class="boton boton-rojo-block">
                    </form>
                </td>
            </tr>
            <?php endwhile;?>

        </tbody>
    </table>

</main>

<?php
    //Cerrar la conexión de la base de datos
    mysqli_close($db);
    
    include '../includes/templates/footer.php';
?>