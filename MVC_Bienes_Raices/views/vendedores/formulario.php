<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Nombre:</label>
    <input type="text" name = "vendedor[nombre]" id="nombre" value="<?php echo s($vendedor->nombre); ?>">
    
    <label for="apellido">Apellido:</label>
    <input type="text" name = "vendedor[apellido]" id="apellido" value="<?php echo s($vendedor->apellido); ?>">

    <label for="telefono">Telefono:</label>
    <input type="text" name = "vendedor[telefono]" id="telefono" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>
