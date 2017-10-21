<?php
namespace sistema;

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

class ControladorFrontal {
    
    const PAQUETE_CONTROLADORES = "controlador";
    const PAQUETE_SISTEMA = "sistema";
    /**
     * @var Ruteador $ruteador
     */
    private $ruteador;
    /**
     *
     * @var Peticion $peticion;
     */
    private $peticion;
    /**
     *
     * @var boolean
     */
    private $mostrarErrores;
    private $direccion;
    
    public function __construct($url, $direccion, $mostrarErrores = false) {
        $this->ruteador = new Ruteador($url);
        $this->peticion = new Peticion();
        $this->mostrarErrores = $mostrarErrores;
        $this->direccion = $direccion;
    }
    
    public function agregarDatosPeticion($datos, $tipo) {
        foreach ($datos as $llave => $valor) {
            $this->peticion->asignar($llave, $valor, $tipo);
        }
    }
    
    public function ejecutar() {
        try {
            $rutaClase = "";
            $this->ruteador->analizar();
            $clase = $this->ruteador->obtenerControlador();
            $metodo = $this->ruteador->obtenerMetodo();
            $rutaClaseTemp = self::PAQUETE_SISTEMA . "\\" . str_replace("_", "\\", $clase);
            if (class_exists($rutaClaseTemp)) {
                $rutaClase = $rutaClaseTemp;
            }
            $rutaClaseTemp = self::PAQUETE_CONTROLADORES . "\\" . str_replace("_", "\\", $clase);
            if (class_exists($rutaClaseTemp)) {
                $rutaClase = $rutaClaseTemp;
            }
            if (empty($rutaClase) == false) {
                /* @var Controlador $controlador */
                $controlador = new $rutaClase($this->peticion);
                $controlador->asignarDireccion($this->direccion);
                if (is_callable(array($controlador, $metodo))) {
                    echo call_user_func_array(array($controlador, $metodo), $this->ruteador->obtenerParametros());
                    return;
                } else {
                    throw new \ErrorException("La definicion del metodo $metodo no existe en la clase $clase");
                }
            } else {
                throw new \ErrorException("La clase $clase no esta declarada");
            }
        } catch (\ErrorException $ex) {
            if ($this->mostrarErrores) {
                $error = new ErrorControlador($this->peticion);
                echo $error->ejecutarError($ex);
            }
        }
    }
}
