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
        <style type="text/css">
        body {
            font-size: 1.3em;
            margin: 1em;
            padding: 0;
            color: red;
        }
        h1 {
            color: cadetblue;
        }
        </style>
    </head>
    <body>
        <h1>Error Nano Framework</h1>
        <div><strong>Archivo: </strong><?php echo $archivo; ?></div>
        <div><strong>L&iacute;nea de c&oacute;digo: </strong><?php echo $linea; ?></div>
        <div><strong>C&oacute;digo de error: </strong><?php echo $error; ?></div>
        <div><strong>Mensaje: </strong><?php echo $mensaje; ?></div>
    </body>
</html>