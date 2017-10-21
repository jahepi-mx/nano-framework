<?php
namespace controlador\usuario;

use sistema\Controlador;
use sistema\Peticion;
use sistema\Vista;
use modelo\com\jahepi\Usuario;

/**
 * Description of Index
 *
 * @author javier.hernandez
 */
class Principal extends Controlador {
    
    private $sesion;
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
        $this->sesion = $this->obtenerPeticion()->obtenerSesion();
        $this->sesion->iniciar();
        $this->estaConectado();
    }
    
    private function estaConectado() {
        $usuario = $this->sesion->obtenerValor("usuario");
        if ($usuario == null) {
            $this->redireccionar("usuario_Acceso", "salir");
        }
    }

    public function index() {
        $usuario = $this->sesion->obtenerValor("usuario");
        $usuarios = Usuario::obtenerUsuarios();
        $vista = new Vista();
        $vista->agregarVariable("usuarios", $usuarios);
        $vista->agregarVariable("sesion", $usuario->obtenerNombre());
        $vista->agregarVariable("mensaje", $this->sesion->obtenerValorFlash("mensaje"));
        $salida = $vista->dibujar("usuario/principal.php");
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida($salida);
        return $respuesta;
    }
    
    public function guardar($id = 0) {
        $errores = array();
        $nombre = "";
        $clave = "";
        
        if ($this->obtenerPeticion()->esPOST()) {
            $id = $this->obtenerPeticion()->obtenerPost("id");
            $nombre = $this->obtenerPeticion()->obtenerPost("nombre");
            $clave = $this->obtenerPeticion()->obtenerPost("clave");
            $usuario = new Usuario($nombre, $clave, $id);
            
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio!";
            }
            
            if (empty($clave)) {
                $errores[] = "La clave es obligatoria!";
            }
            
            if (empty($errores)) {
                Usuario::guardar($usuario);
                $this->sesion->agregarValorFlash("mensaje", "El usuario " . $usuario->obtenerNombre() . " ha sido guardado!");
                $this->redireccionar("usuario_Principal", "index");
                return;
            }
        }
        
        if ($id > 0) {
            $usuario = Usuario::obtenerUsuarioPorId($id);
            $nombre = $usuario->obtenerNombre();
            $clave = $usuario->obtenerClave();
            $id = $usuario->obtenerId();                    
        }
        $vista = new Vista();
        $vista->agregarVariable("nombre", $nombre);
        $vista->agregarVariable("clave", $clave);
        $vista->agregarVariable("id", $id);  
        $vista->agregarVariable("mensaje", implode("<br />", $errores));
        $salida = $vista->dibujar("usuario/guardar.php"); 
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida($salida);
        return $respuesta;
    }
    
    public function borrar($id) {
        if (Usuario::borrar($id)) {
            $this->sesion->agregarValorFlash("mensaje", "El usuario ha sido borrado!");
        } else {
            $this->sesion->agregarValorFlash("mensaje", "El usuario no PUDO ser borrado!");
        }
        $this->redireccionar("usuario_Principal", "index");
    }
}