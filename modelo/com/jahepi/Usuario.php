<?php
namespace modelo\com\jahepi;

use sistema\BD;
/**
 * Description of Usuario
 *
 * @author javier.hernandez
 */

class Usuario {
    
    private $id;
    private $nombre;
    private $clave;
    
    public function __construct($nombre, $clave, $id = 0) {
        
        $this->id = $id;
        $this->nombre = $nombre;
        $this->clave = $clave;
    }
    
    /**
     * 
     * @return \Doctrine\DBAL\Connection
     */
    private static function db() {
        return BD::instancia()->obtenerConexion("bd1");
    }
    
    public static function obtenerUsuarioPorId($id) {
        $usuario = null;
        $sql = "SELECT id, nombre, clave FROM usuarios WHERE id = ?";
        $stmt = self::db()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();       
        if ($stmt->rowCount() > 0) {
            $dato = $stmt->fetch();
            $usuario = new Usuario($dato['nombre'], $dato['clave'], $dato['id']);
        }
        return $usuario;
    }
    
    public static function obtenerUsuario($nombre, $clave) {
        $usuario = null;
        $claveCifrada = sha1($clave);
        $sql = "SELECT id, nombre, clave FROM usuarios WHERE nombre = ? AND clave = ?";
        $stmt = self::db()->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $claveCifrada);
        $stmt->execute();       
        if ($stmt->rowCount() > 0) {
            $dato = $stmt->fetch();
            $usuario = new Usuario($dato['nombre'], $dato['clave'], $dato['id']);
        }
        return $usuario;
    }
    
    /**
     * 
     * @return \modelo\com\jahepi\Usuario[]
     */
    public static function obtenerUsuarios() {
        $usuarios = array();
        $sql = "SELECT id, nombre, clave FROM usuarios";
        $stmt = self::db()->query($sql);
        $stmt->execute();       
        while ($dato = $stmt->fetch()) {          
            $usuarios[] = new Usuario($dato['nombre'], $dato['clave'], $dato['id']);
        }
        return $usuarios;
    }
    
    public static function guardar(Usuario $usuario) {
        $id = $usuario->obtenerId();
        if (empty($id)) {
            self::db()->insert('usuarios', array(
                'nombre' => $usuario->obtenerNombre(),
                'clave' => sha1($usuario->obtenerClave()),
            ));
            $usuario->id = self::db()->lastInsertId();
        } else {
            self::db()->update('usuarios', array(
                'nombre' => $usuario->obtenerNombre(),
                'clave' => sha1($usuario->obtenerClave()),
            ), array('id' => $usuario->obtenerId()));
        }
        return true;
    }
    
    public static function borrar($id) {
        $usuario = Usuario::obtenerUsuarioPorId($id);
        if ($usuario) {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = self::db()->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            return true;
        }
        return false;
    }
    
    public function obtenerId() {
        return $this->id;
    }
    
    public function obtenerClave() {
        return $this->clave;
    }
    
    public function obtenerNombre() {
        return $this->nombre;
    }
}
