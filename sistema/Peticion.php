<?php
namespace sistema;

use sistema\Sesion;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Peticion
 *
 * @author javier.hernandez
 */
class Peticion {
    
    const TIPO_GET = 0;
    const TIPO_POST = 1;
    const TIPO_FILES = 2;
    const TIPO_COOKIE = 3;
    const TIPO_SERVER = 4;
    
    private $get;
    private $post;
    private $files;
    private $cookie;
    private $server;
    /**
     *
     * @var Sesion $sesion
     */
    private $sesion;

    public function __construct() {
        $this->get = array();
        $this->post = array();
        $this->files = array();
        $this->cookie = array();
        $this->server = array();
        $this->sesion = new Sesion();
    }
    
    public function obtenerGet($llave) {
        if (key_exists($llave, $this->get)) {
            return $this->get[$llave];
        }
        return null;
    }

    public function obtenerPost($llave) {
        if (key_exists($llave, $this->post)) {
            return $this->post[$llave];
        }
        return null;
    }
    
    public function obtenerCookie($llave) {
        if (key_exists($llave, $this->cookie)) {
            return $this->cookie[$llave];
        }
        return null;
    }
    
    public function obtenerServer($llave) {
        if (key_exists($llave, $this->server)) {
            return $this->server[$llave];
        }
        return null;
    }
    
    public function obtenerFiles($llave) {
        if (key_exists($llave, $this->files)) {
            return $this->files[$llave];
        }
        return null;
    }
    
    public function esPOST() {
        return count($this->post) > 0;
    }
    
    public function esGET() {
        return count($this->get) > 0;
    }
    
    public function asignar($llave, $valor, $tipo) {
        $valorSeguro = filter_var($valor, FILTER_SANITIZE_STRING);
        $llaveSegura = filter_var($llave, FILTER_SANITIZE_STRING);
        switch ($tipo) {
            case self::TIPO_GET: $this->get[$llaveSegura] = $valorSeguro; break;
            case self::TIPO_POST: $this->post[$llaveSegura] = $valorSeguro; break;
            case self::TIPO_COOKIE: $this->cookie[$llaveSegura] = $valorSeguro; break;
            case self::TIPO_FILES: $this->files[$llaveSegura] = $valorSeguro; break;
            case self::TIPO_SERVER: $this->server[$llaveSegura] = $valorSeguro; break;
        }
    }
    /**
     * 
     * @return Sesion
     */
    public function obtenerSesion() {
        return $this->sesion;
    }
}
