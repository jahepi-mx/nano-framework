# nano-framework
Nano framework es un marco de trabajo muy pequeñito en PHP totalmente en español que utiliza el patrón MVC (Modelo, Vista, Controlador) para la separación de código por responsabilidades en los proyectos.

El marco de trabajo cuenta con:

Soporte de namespaces.
Integración con DBAL (Capa de Abstracción de Base de Datos) de Doctrine, soporte de los motores más populares como MySQL y Postgres.
Auto-completado total al integrarse con algún IDE como NetBeans o Eclipse.

## Estructura

- ./controlador: Contiene las clases controladoras.
- ./libreria: Contiene las clases de terceros.
- ./modelo: Clases de la capa de negocio, responsables de la recuperación y guardado de información en un medio persistente (Base de datos, XMLS, TXTS, etc.), envío de
correos, servicios web, etc.
- ./recursos: Contiene las carpetas CSS y JS para almacenar los archivos CSS y scripts
en Javascript.
- ./sistema: Clases necesarias para el funcionamiento del framework.
- ./vista: Almacena los archivos PHP que pintan las páginas (código html).

## Requisitos

- Apache
- PHP 5.3+

## Configuración

El primer paso es habilitar el módulo mod_rewrite de Apache, hay muchas guías disponibles en Google.

Lo siguiente es editar el archivo config.php que se encuentra en la carpeta sistema:

```
// Constante que define la direccion del proyecto
define('DIRECCION', 'http://localhost/nano');

// Constante booleana para indiciar si el proyecto muestra errores
define('MOSTRAR_ERRORES', true);

// Arreglo que almacena las conexiones disponibles a la base de datos en el proyecto.
$conexiones = array(
    'bd1' => 'mysql://root:1234@localhost/test'
);
```

La primera constante **DIRECCION** es la ruta de nuestro proyecto, la constante **MOSTRAR_ERRORES** es una bandera para activar o desactivar los errores en el proyecto y por último la variable **$conexiones**, arreglo asociativo con el listado de conexiones a la base de datos, **bd1** es la llave con la que podremos recuperar la referencia de conexión desde código, y los datos de conexión **mysql://root:1234@localhost/test**, donde mysql es el motor a utilizar, root es el usuario, 1234 es el password, localhost el dominio o IP del servidor y test el nombre de la base de datos, se pueden agregar las conexiones que se deseen y hacer referencia desde código usando la llave que se asignó.

## Controladores

Los controladores se crean en la carpeta controlador, ejemplo de implementación:

```
namespace controlador;
 
use sistema\Controlador;
use sistema\Peticion;
 
class Index extends Controlador {
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
    }
 
    public function index() {
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida("Hola Mundo!");
        return $respuesta;
    }
}
```

Por defecto se crea una instancia del controlador Index y se llama a su método index si se entra a la dirección del proyecto sin indicar ningún parámetro, las siguientes direcciones imprimirían Hola Mundo!:

- **http://localhost/nano**
- **http://localhost/nano/Index/index**

No estamos limitados a crear los controladores en la carpeta controlador, también podemos crear subcarpetas dentro de esta y organizar nuestros controladores de una mejor manera, para ello también hay que indicar el namespace en el controlador ya que el nombre del namespace se traduce a la ruta de carpetas del proyecto, por ejemplo:

```
namespace controlador\modulo1;

use sistema\Controlador;
use sistema\Peticion;

class Index extends Controlador {
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
    }

    public function index() {
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida("Hola Mundo!");
        return $respuesta;
    }
}
```

El controlador estará ubicado en la ruta **controlador/modulo1**, ve además como el namespace está declarado: **namespace controlador\modulo1;**

Para llamar al método index de este controlador llamamos la siguiente dirección desde nuestro navegador de preferencia:

**http://localhost/nano/modulo1_Index/index**

Con el guión bajo separamos el namespace de la clase desde la dirección a invocar, por lo que el guión bajo no debería se utilizado como parte del nombre de las clases.

**Nota:** Recuerda que los controladores sólo tienen como responsabilidad manejar los eventos del sistema.

## Modelos

Las clases del modelo van en la carpeta de modelo, al igual que los controladores podemos organizar las clases en carpetas y sólo definir el namespace de acuerdo a la ruta de la carpeta donde se encuentra ubicada, es importante recalcar que en esta capa del modelo va la lógica principal de nuestra aplicación por lo que además de incluir los servicios de recuperación y guardado de datos a algún medio persistente, también podemos hacer uso de otros servicios como el envío de correo, la validación de datos, etc.

La clases definitivas en el modelo, quedan a nuestro criterio el cómo crearlas, tenemos la libertad de hacer nuestro modelado de clases, coloco ejemplo de implementación de una clase llamada Usuario:

```
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
```

El namespace de esta clase es **modelo\com\jahepi**, por lo que la clase se encuentra en la siguiente ruta de carpetas **modelo/com/jahepi**.

Otro punto importante es la siguiente instrucción:

```
BD::instancia()->obtenerConexion("bd1");
```
Con la cual podemos hacer referencia a la conexión de la base de datos que definimos en el archivo config.php en el apartado de configuración.

## Vistas

Las vistas o los archivos que tienen los elementos visuales se deben guardar en la carpeta vista, desde nuestro controlador podemos cargar un vista de la siguiente forma:

```
namespace controlador;
 
use sistema\Controlador;
use sistema\Peticion;
use sistema\Vista;
 
/**
 * Description of Index
 *
 * @author javier.hernandez
 */
class Index extends Controlador {
    
    public function __construct(Peticion $peticion) {
        parent::__construct($peticion);
    }
 
    public function index() {
        $vista = new Vista();
        $salida = $vista->dibujar("bienvenida.php");
        $respuesta = $this->obtenerRespuesta();
        $respuesta->agregarSalida($salida);
        return $respuesta;
    }
}
```

Donde **bienvenida.php** es nuestro archivo vista que se encuentra ubicado en vistas/bienvenida.php:

```
<html>
    <head>
        <title>Nano</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Nano Framework 2015</h1>
    </body>
</html>
```

Sólo el controlador tiene que regresar una instancia de tipo **Respuesta** donde tenga como salida el contenido de bienvenida.php.

