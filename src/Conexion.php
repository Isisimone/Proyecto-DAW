<?php
//Espacio de nombres donde se encuentra la clase
namespace Clases;
//Importamos la clase PDO y PDOException para conectar con la BBDD
use PDO;
use PDOException;
//Definimos la clase Conexion
class Conexion {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $dsn;
    protected $conexion;

    public function __construct(){
        $so = PHP_OS;
        if (stripos($so, 'WIN') !== false) {
            $ruta_clave = 'c:/xampp/conexion.txt';
        } else {
            $ruta_clave = '/var/www/conexion.txt';
        }
        if (!file_exists($ruta_clave)) {
            die("Error: No se encontró el archivo de la conexión a la base de datos.");
        } else {
            $datos = file($ruta_clave);
            $this->host = trim($datos[0]);
            $this->db = trim($datos[1]);
            $this->user = trim($datos[2]);
            $this->pass = trim($datos[3]);
            $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
            $this->crearConexion();

        }
    }

    public function crearConexion() {
        try {
            $this->conexion = new PDO($this->dsn,
                $this->user,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
        return $this->conexion;
    }
}
?>