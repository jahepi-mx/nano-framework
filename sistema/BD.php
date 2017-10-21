<?php
namespace sistema;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author jahepi
 */
class BD {
    
    private static $instancia;
    
    private $parametros;
    private $conexiones;
    
    private function __construct() {
        $this->parametros = array();
        $this->conexiones = array();
    }

    /**
     * 
     * @return BD
     */
    public static function instancia() {
        if (self::$instancia == null) {
            self::$instancia = new BD();
        }
        return self::$instancia;
    }
    
    public function asignarParametros($parametros) {
        $this->parametros = $parametros;
    }
    /**
     * 
     * @return Connection
     */
    public function obtenerConexion($nombre) {
        $conexion = null;
        if (key_exists($nombre, $this->parametros)) {
            $parametro = $this->parametros[$nombre];         
            if (key_exists($nombre, $this->conexiones)) {
                $conexion = $this->conexiones[$nombre];
            } else {
                $this->conexiones[$nombre] = DriverManager::getConnection(array('url' => $parametro), null, null);
                $conexion = $this->conexiones[$nombre];
            }
        }
        return $conexion;
    }
}
