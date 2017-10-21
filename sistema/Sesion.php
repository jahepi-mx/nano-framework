<?php
namespace sistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sesion
 *
 * @author javier.hernandez
 */
class Sesion {
    
    const LLAVE_FLASH = "LLaveValorFlash";
    
    public function __construct() {
        
    }
    
    public function iniciar() {
        session_start();
    }
    
    public function agregarValor($llave, $valor) {
        $_SESSION[$llave] = $valor;
    }
    
    public function obtenerValor($llave) {
        if (key_exists($llave, $_SESSION)) {
            return $_SESSION[$llave];
        }
        return null;
    }
    
    public function agregarValorFlash($llave, $valor) {
        $this->agregarValor(self::LLAVE_FLASH . $llave, $valor);
    }
    
    public function obtenerValorFlash($llave) {
        $valor = $this->obtenerValor(self::LLAVE_FLASH . $llave);
        $this->borrarValor(self::LLAVE_FLASH . $llave);
        return $valor;
    }
    
    public function borrarValor($llave) {
        unset($_SESSION[$llave]);
    }
    
    public function destruir() {
        session_destroy();
    }
}
