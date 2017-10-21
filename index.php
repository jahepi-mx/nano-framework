<?php
require_once 'sistema/config.php';

if (MOSTRAR_ERRORES) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

use Doctrine\Common\ClassLoader;

require_once 'sistema/CargadorClases.php';
require_once 'sistema/dbal/Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader('Doctrine', 'sistema/dbal/');
$classLoader->register();

set_error_handler(function($error, $mensaje, $archivo, $linea) {
    throw new ErrorException($mensaje, 0, $error, $archivo, $linea);
});

sistema\CargadorClases::ejecutar(__DIR__);
sistema\BD::instancia()->asignarParametros($conexiones);

// Instancia Controlador Frontal
$url = $_SERVER['REQUEST_URI'];
$controladorFrontal = new sistema\ControladorFrontal($url, DIRECCION, MOSTRAR_ERRORES);
$controladorFrontal->agregarDatosPeticion($_GET, sistema\Peticion::TIPO_GET);
$controladorFrontal->agregarDatosPeticion($_POST, sistema\Peticion::TIPO_POST);
$controladorFrontal->agregarDatosPeticion($_COOKIE, sistema\Peticion::TIPO_COOKIE);
$controladorFrontal->agregarDatosPeticion($_FILES, sistema\Peticion::TIPO_FILES);
$controladorFrontal->agregarDatosPeticion($_SERVER, sistema\Peticion::TIPO_SERVER);
$controladorFrontal->ejecutar();
