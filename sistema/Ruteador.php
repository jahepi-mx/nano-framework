<?php
namespace sistema;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ruteador
 *
 * @author jahepi
 */
class Ruteador {
    
    const CONTROLADOR_POR_DEFECTO = 'Index';
    const METODO_POR_DEFECTO = 'index';

    private $url;
    private $controlador;
    private $metodo;
    private $parametros;
    
    public function __construct($url) {
        $this->url = filter_var($url, FILTER_SANITIZE_STRING);
        $this->parametros = array();
        $this->controlador = self::CONTROLADOR_POR_DEFECTO;
        $this->metodo = self::METODO_POR_DEFECTO;
    }
    
    public function obtenerControlador() {
        return $this->controlador;
    }
    
    public function obtenerMetodo() {
        return $this->metodo;
    }
    
    public function obtenerParametros() {
        return $this->parametros;
    }
    
    public function analizar() {
        $ruta = "/" . basename(DIRECCION) . "/";
        $ruta = str_replace($ruta, "", $this->url);
        $urlCol = explode("/", $ruta);
        $controlador = array_shift($urlCol);
        if (empty($controlador) == false) {
            $controladorCol = explode("?", $controlador);
            $this->controlador = array_shift($controladorCol);
        }
        $metodo = array_shift($urlCol);
        if (empty($metodo) == false) {
            $metodoCol = explode("?", $metodo);
            $this->metodo = array_shift($metodoCol);
        }
        foreach ($urlCol as $valor) {
            $valorCol = explode("?", $valor);
            $valorSeguro = array_shift($valorCol);
            $this->parametros[] = urldecode($valorSeguro);
        }
    }
}
