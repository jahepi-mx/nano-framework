<?php
namespace sistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cargador
 *
 * @author jahepi
 */
class CargadorClases {
    
    public static function ejecutar() {
        spl_autoload_register(function($clase) {
            $clase = str_replace('\\', DIRECTORY_SEPARATOR, $clase);
            $archivo = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "$clase.php";
            if (is_readable($archivo)) {
                require_once $archivo;
            }
        });
    }   
}
