<?php

namespace Clases; //Espacio de nombres

use PDO;            //Librerías PDO
use PDOException;
//La clase Ajuste maneja la BBDD de ajustes
class Ajuste {
    // Atributos de la clase
    private $id;
    private $nombre_ajuste;
    private $valor;
    
    // Constructor de la clase
    public function __construct() {
    }

    // Método para obtener todos los ajustes de la base de datos
    public function obtenerAjustes() {
        $conexion = new Conexion();
        // Preparo la consulta
        $consulta = "SELECT * FROM tajuste";
        // Ejecuto la consulta
        $stmt = $conexion->conexion->prepare($consulta);
        $stmt->execute();
        // Devuelvo el resultado de la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un ajuste de la base de datos
    public function obtenerAjuste($id) {
        $conexion = new Conexion();
        // Preparo la consulta
        $consulta = "SELECT * FROM tajuste WHERE id_ajuste = :id_ajuste";
        // Preparo el array de parámetros
        $stmt = $conexion->conexion->prepare($consulta);
        $stmt->bindParam(':id_ajuste', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Método para crear un nuevo ajuste
    public function crear(string $nombre, string $valor){
        $this->id=null;
        $this->setNombreAjuste($nombre);
        $this->setValor($valor);
        $this->grabar();
    }

    // Método para grabar un ajuste en la base de datos
    public function grabar() {
        $conexion = new Conexion();
        // Preparo la consulta
        try {
            //Si no hay un id en los parámetros la consulta es un insert
            if ($this->id==0 || is_null($this->id)){
                $consulta = "INSERT INTO tajuste (NOM_AJUSTE, VALOR_AJUSTE) VALUES (:nom_ajuste, :valor_ajuste)";
                $stmt = $conexion->conexion->prepare($consulta); 
            //Si hay id la consulta es un update
            }else{
                $consulta = "UPDATE tajuste SET NOM_AJUSTE = :nom_ajuste, VALOR_AJUSTE = :valor_ajuste WHERE ID_AJUSTE = :id_ajuste";
                $stmt = $conexion->conexion->prepare($consulta); 
                //Al ser un update añade el parámetro de id
                $stmt->bindParam(':id_ajuste', $id, PDO::PARAM_INT);
            }
            //Resto de parámetros/campos para la consulta
            $stmt->bindParam(':nom_ajuste', $this->nombre_ajuste, PDO::PARAM_STR);
            $stmt->bindParam(':valor_ajuste', $this->valor, PDO::PARAM_STR);
            //Ejecutamos la consulta
            $stmt->execute();
            //termina la función devolviendo true
            return true;
        } catch (PDOException $e) {
            //En caso de error de conexión muestra mensaje y devuelve false
            echo "Error al grabar el ajuste: " . $e->getMessage();
            return false;
        }
    }
    //Método para actualizar un ajuste directamente sin parametrizar el objeto
    public function actualizarAjuste($id, $nombre_ajuste, $valor) {
        $conexion = new Conexion();
        // Preparo la consulta
        try {
            $consulta = "UPDATE tajuste SET nom_ajuste = :nom_ajuste, valor_ajuste = :valor_ajuste WHERE id_ajuste = :id_ajuste";
            $stmt = $conexion->conexion->prepare($consulta);
            //Parametriza la consulta
            $stmt->bindParam(':id_ajuste', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom_ajuste', $nombre_ajuste, PDO::PARAM_STR);
            $stmt->bindParam(':valor_ajuste', $valor, PDO::PARAM_STR);
            //Ejecuta y develve true
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            //si falla muestra error y devuelve false
            echo "Error al actualizar el ajuste: " . $e->getMessage();
            return false;
        }
    }
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< GETTERS Y SETTERS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//Get y set para el Id
public function getId(): int {
    return $this->id;
}

public function setId(int $id): void {
    $this->id = $id;
}

// Getter y Setter para el atributo nombre_ajuste
public function getNombreAjuste(): string {
    return $this->nombre_ajuste;
}

public function setNombreAjuste(string $nombre_ajuste): void {
    $this->nombre_ajuste = $nombre_ajuste;
}

// Getter y Setter para el atributo valor
public function getValor(): string {
    return $this->valor;
}

public function setValor(string $valor): void {
    $this->valor = $valor;
}
}