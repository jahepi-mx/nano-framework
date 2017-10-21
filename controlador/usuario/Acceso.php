<?php
namespace controlador\usuario;

use sistema\Controlador;
use sistema\Peticion;
use sistema\Vista;
use modelo\com\jahepi\Usuario;
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
class Acceso extends Controlador {
    
    private $sesion;
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
        $this->sesion = $this->obtenerPeticion()->obtenerSesion();
        $this->sesion->iniciar();
    }

    public function index() {
        $vista = new Vista();
        $vista->agregarVariable("mensaje", $this->sesion->obtenerValorFlash("mensaje"));
        $salida = $vista->dibujar("usuario/acceso.php");
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida($salida);
        return $respuesta;
    }
    
    public function entrar() {
        $nombre = $this->obtenerPeticion()->obtenerPost("nombre");
        $clave = $this->obtenerPeticion()->obtenerPost("clave");
        $usuario = Usuario::obtenerUsuario($nombre, $clave);
        if ($usuario != null) {
            $this->sesion->agregarValor("usuario", $usuario);
            $this->redireccionar("usuario_Principal", "index");
        } else {
            $this->sesion->agregarValorFlash("mensaje", "El usuario no es correcto!");
            $this->redireccionar("usuario_Acceso", "index");
        }
    }
    
    public function salir() {
        $this->sesion->destruir();
        $this->redireccionar("usuario_Acceso", "index");
    }
}

