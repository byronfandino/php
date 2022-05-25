<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" name = "propiedad[titulo]" id="titulo" value="<?php echo s($propiedad->titulo); ?>">
    
    <label for="precio">Precio:</label>
    <input type="number" name = "propiedad[precio]" id="precio" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" name="propiedad[imagen]" id="imagen" accept="image/jpeg, image/png">

    <?php if($propiedad->imagen) : ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen Casa" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>

</fieldset>

<fieldset>
    <legend>información Propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" name="propiedad[habitaciones]" id="habitaciones" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños</label>
    <input type="number" name="propiedad[wc]" id="wc" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <option selected value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) : ?>
            <option 
                    <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
                    value="<?php echo s($vendedor->id); ?>">
                    <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> 
            </option>

        <?php endforeach; ?>

    </select>

</fieldset>
