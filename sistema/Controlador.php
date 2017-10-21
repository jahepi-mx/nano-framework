<?php
namespace sistema;

use sistema\Peticion;
use sistema\Respuesta;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorFrontal
 *
 * @author javier.hernandez
 */
class Controlador {
    
    /** @var Peticion $peticion */
    private $peticion;
    /** @var Respuesta $repuesta */
    private $respuesta;
    
    private $direccion;
    
    public function __construct(Peticion $peticion) {
        $this->peticion = $peticion;
        $this->respuesta = new Respuesta();
    }
    
    /**
     * @return Peticion
     */
    public function obtenerPeticion() {
        return $this->peticion;
    }
    
    /**
     * @return Respuesta
     */
    public function obtenerRespuesta() {
        return $this->respuesta;
    }
    
    public function asignarDireccion($direccion) {
        $this->direccion = $direccion;
    }
    
    public function obtenerDireccion() {
        return $this->direccion;
    }
    
    public function redireccionar($controlador, $metodo, $parametros = array()) {
        $cabecera = "";
        if (empty($parametros)) {
            $cabecera = 'Location: ' . $this->direccion . '/' . $controlador . '/' . $metodo;
        } else {
            $cabecera = 'Location: ' . $this->direccion . '/' . $controlador . '/' . $metodo . '/' . implode("/", $parametros);
        }
        $respuesta = new Respuesta();
        $respuesta->agregarCabecera($cabecera);
        echo $respuesta;
    }
}
