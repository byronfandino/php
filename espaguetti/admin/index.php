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

?>

<main class="main-ct">

    <h1>Administrador</h1>
    
    <?php if (intval($resultado) === 1) : ?>
            <div class="notificacion">
                <div class="alerta exito">
                    <p>
                        <?php echo "Registro creado correctamente"; ?>
                    </p>
                </div>
            </div>
    <?php endif; ?>

    <div class="navegacion">
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nuevo cliente</a>
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
                    <a href="admin/clientes/eliminar.php?id=<?php echo $registro['id']; ?>" class="boton boton-rojo-block">Eliminar</a>
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