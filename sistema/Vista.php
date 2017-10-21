<?php
namespace sistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vista
 *
 * @author javier.hernandez
 */
class Vista {
    
    const RUTA_VISTAS = "./vista/";
    
    private $variables;
    
    public function __construct() {
        $this->variables = array();
    }
    
    public function agregarVariable($nombre, $valor) {
        $this->variables[$nombre] = $valor;
    }
    
    public function limpiarVariables() {
        $this->variables = array();
    }
    
    public function dibujar($view) {
        ob_start();
        extract($this->variables);
        include_once(self::RUTA_VISTAS . $view);
        $vista = ob_get_contents();
        ob_end_clean();
        return $vista;
    }
}
