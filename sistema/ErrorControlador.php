<?php
namespace sistema;

use sistema\Controlador;
use sistema\Vista;
use sistema\Respuesta;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorControlador
 *
 * @author jahepi
 */
class ErrorControlador extends Controlador {
    //put your code here
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
    }
    
    public function ejecutarError(\ErrorException $e) {
        ob_clean();
        $vista = new Vista();
        $vista->agregarVariable("error", $e->getCode());
        $vista->agregarVariable("linea", $e->getLine());
        $vista->agregarVariable("mensaje", $e->getMessage());
        $vista->agregarVariable("archivo", $e->getFile());
        $respuesta = new Respuesta();
        $respuesta->agregarSalida($vista->dibujar("error/error.php"));
        return $respuesta;       
    }
}
