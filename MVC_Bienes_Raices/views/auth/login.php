<main class="contenedor seccion">
        <h1>Iniciar Sesión</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form action="" method="POST" class="formulario" action="/login">

            <fieldset>
                
                <legend>Email y Password</legend>
                
                <label for="email">E-mail</label>
                <input type="email"  name="email" id="email" required>
                
                <label for="password">Password</label>
                <input type="password" name="password"id="password" required>
            </fieldset>

            <input type="submit" value="Iniciar sesión" class="boton boton-verde">
        </form>
    </main>