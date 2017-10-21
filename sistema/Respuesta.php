<?php
namespace sistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Respuesta
 *
 * @author jahepi
 */
class Respuesta {
    //put your code here
    private $cabeceras;
    private $salidas;
    
    public function __construct() {
        $this->cabeceras = array();
        $this->salidas = array();
    }
    
    public function agregarCabecera($cabecera) {
        $this->cabeceras[] = $cabecera;
    }
    
    public function agregarSalida($salida) {
        $this->salidas[] = $salida;
    }
    
    public function __toString() {
        $respuesta = "";
        foreach ($this->cabeceras as $cabecera) {
            header($cabecera);
        }
        foreach ($this->salidas as $salida) {
            $respuesta .= $salida;
        }
        return $respuesta;
    }
}
