<?php

namespace Clases; //Espacio de nombres

use PDO;            //Librerías PDO
use PDOException;

class Ajuste extends Conexion{
    //Atributos de la clase
    private $id;
    private $nombre_ajuste;
    private $valor;
    
    //Constructor de la clase
    public function __construct(){
        //Llamo al constructor de la clase padre
        parent::__construct();
    }

    //Método para obtener todos los ajustes de la base de datos
    public function obtenerAjustes(){
        //Preparo la consulta
        $consulta = "SELECT * FROM tajuste";
        //Ejecuto la consulta
        $stmt = $this->conexion->prepare($consulta);
        $stmt->execute();
        //Devuelvo el resultado de la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Método para obtener un ajuste de la base de datos
    public function obtenerAjuste($id){
        //Preparo la consulta
        $consulta = "SELECT * FROM tajuste WHERE id_ajuste = :id_ajuste";
        //Preparo el array de parámetros
        $stmt = $this->prepare($consulta);
        $stmt->bindParam(':id_ajuste', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Método para actualizar un ajuste en la base de datos
    public function actualizarAjuste($id, $ajuste, $fecha, $descripcion){
        //Preparo la consulta
        try {
            $consulta = "UPDATE tajuste SET nom_ajuste = :nom_ajuste, valor_ajuste = :valor_ajuste WHERE id_ajuste = :id_ajuste";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id_ajuste', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom_ajuste', $nombre_ajuste, PDO::PARAM_STR);
            $stmt->bindParam(':valor_ajuste', $valor, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar el ajuste: " . $e->getMessage();
            return false;
        }
    }
}