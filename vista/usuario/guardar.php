<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Nano</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo DIRECCION; ?>/recursos/css/sitio.css"> 
        <script src="<?php echo DIRECCION; ?>/recursos/js/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        <h1>Guardar Usuario</h1>
        <?php if ($mensaje) { ?>
        <div class="error"><?php echo $mensaje; ?></div>
        <?php } ?>
        <form id="acceso" class="basic-grey" method="post" action="<?php echo DIRECCION ?>/usuario_Principal/guardar">
            <h1>Formulario 
                <span>Llena los campos.</span>
            </h1>
            <label for="nombre">
                <span>Nombre:</span>
                <input type="text" size="20" name="nombre" id="nombre" value="<?php echo $nombre; ?>" />
            </label>
            <label for="clave">
                <span>Clave</span>
                <input type="text" size="20" name="clave" id="clave" value="<?php echo $clave; ?>" />
            </label>
            <label>
                <span>&nbsp;</span>
                <input type="hidden" size="20" name="id" id="id" value="<?php echo $id; ?>" />
                <input type="submit" value="Guardar" class="button" />
            </label>
        </form>
        <br /><a href="<?php echo DIRECCION ?>/usuario_Principal/index">Regresar</a>
    </body>
</html>
