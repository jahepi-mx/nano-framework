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
        <ul class="menu">
            <li><a href="<?php echo DIRECCION; ?>/usuario_Principal/guardar">Agregar Usuario</a></li>
            <li><a href="<?php echo DIRECCION; ?>/usuario_Acceso/salir">Cerrar Sesi&oacute;n de <?php echo $sesion; ?></a></li>
        </ul>
        <h1>Acceso ABC Usuarios</h1>
        <?php if ($mensaje) { ?>
        <div class="exito"><?php echo $mensaje; ?></div>
        <?php } ?>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Clave</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            <thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario->obtenerId(); ?></td>
                    <td><?php echo $usuario->obtenerNombre(); ?></td>
                    <td><?php echo $usuario->obtenerClave(); ?></td>
                    <td><a href="<?php echo DIRECCION; ?>/usuario_Principal/guardar/<?php echo $usuario->obtenerId(); ?>">Actualizar</a></td>
                    <td><a href="<?php echo DIRECCION; ?>/usuario_Principal/borrar/<?php echo $usuario->obtenerId(); ?>">Borrar</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>

