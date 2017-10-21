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
        <h1>Nano Framework 2015</h1>
        <a href="<?php echo DIRECCION; ?>/usuario_Acceso">Demostracion Login y ABC de Usuarios</a>
        <div class="demo">Datos de acceso:<br /><hr />Usuario: admin<br />Clave: admin</div>
        <div class="demo">
            <pre>
            SQL de la tabla de la demostraci&oacute;n:
            <hr />
            CREATE TABLE `usuarios` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `nombre` varchar(255) DEFAULT NULL,
                `clave` varchar(40) DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

              INSERT INTO usuarios VALUES (null, 'admin', SHA1('admin'));
            </pre>
        </div>
    </body>
</html>

