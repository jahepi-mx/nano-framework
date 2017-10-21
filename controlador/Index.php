<?php
namespace controlador;

use sistema\Controlador;
use sistema\Peticion;
use sistema\Vista;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author javier.hernandez
 */
class Index extends Controlador {
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
    }

    public function index() {
        $vista = new Vista();
        $salida = $vista->dibujar("bienvenida.php");
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida($salida);
        return $respuesta;
    }
}
