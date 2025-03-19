<?php

namespace Clases;
use PDO;
use PDOException;
use DateTime;

class Transaccion{
    // Atributos
    private int $cod_Transaccion;
    private string $tip_trans;
    private string $des_trans;
    private int $cod_obj;
    private string $nom_obj;
    private int $cod_usuario;
    private DateTime $fec_sis;
    private string $ip_usuario;

    // Constructor sin parámetros
    public function __construct() {
        $this->tip_trans="";
        $this->des_trans="";
        $this->cod_obj=0;
        $this->nom_obj="";
        $this->ip_usuario="";
        $this->cod_usuario=0;
    }

    

//Método crear transaccion que escribe en la bbdd a partir del objeto
    public function grabar() {
        //try{
        $conexion = new Conexion();
        $sql = "INSERT INTO ttransacciones (TIP_TRANS, DESC_TRANS, COD_OBJ, NOM_OBJ, COD_USUARIO, FEC_SIS, IP_USUARIO) 
                VALUES (:tip_trans, :desc_trans, :cod_obj, :nom_obj, :cod_usuario, :fec_sis, :ip_usuario)";
        $stmt = $conexion->conexion->prepare($sql);
        $stmt->bindValue('tip_trans', $this->tip_trans, PDO::PARAM_STR);
        $stmt->bindValue('desc_trans', $this->des_trans, PDO::PARAM_STR);
        $stmt->bindValue('cod_obj', $this->cod_obj, PDO::PARAM_INT);
        $stmt->bindValue('nom_obj', $this->nom_obj, PDO::PARAM_STR);
        $stmt->bindValue('cod_usuario', $this->cod_usuario, PDO::PARAM_INT);
        $stmt->bindValue('fec_sis', $this->fec_sis->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue('ip_usuario', $this->ip_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $stmt=null;
        return;
        //} catch(PDOException $e) {
        //    echo("Error al grabar la transacción: " . $e->getMessage());
        //    return;
        //}
    }

    //Método para obtener transacciones de la bbdd
    public function obtenerTransacciones(): array {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM ttransacciones";
            // Ejecuto la consulta
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->execute();
            // Devuelvo el resultado de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar transacciones: " . $e->getMessage());
            return [];
        }
        
    }

    //Método para obtener transacciones de la bbdd a partir del código de usuario
    public function obtenerTransaccionesUsuario(int $cod_usuario): array {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM ttransacciones WHERE COD_USUARIO = :cod_usuario";
            // Ejecuto la consulta
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindValue('cod_usuario', $cod_usuario, PDO::PARAM_STR);
            $stmt->execute();
            // Devuelvo el resultado de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar transacciones: " . $e->getMessage());
            return [];
        }
    }

    //Método para obtener transacciones de la bbdd entre 2 fechas
    public function obtenerTransaccionesEntreFechas(DateTime $fec_Ini, DateTime $fec_Fin): array {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM ttransacciones WHERE FEC_SIS BETWEEN :fec1 AND :fec2";
            // Ejecuto la consulta
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindValue('fec1', $fec_Ini->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue('fec2', $fec_Fin->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
            // Devuelvo el resultado de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar transacciones: " . $e->getMessage());
            return [];
        }
    }

    //<<<<<<<<<<<<<<<<<<<<<<<<<< GETTER Y SETTER >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// set y get
public function setCodTransaccion(int $cod_Transaccion): void {
    $this->cod_Transaccion = $cod_Transaccion;
}

public function getCodTransaccion(): int {
    return $this->cod_Transaccion;
}

public function setTipoTrans(string $tip_trans): void {
    $this->tip_trans = $tip_trans;
}

public function getTipoTrans(): string {
    return $this->tip_trans;
}

public function setDesTrans(string $des_trans): void {
    $this->des_trans = $des_trans;
}

public function getDesTrans(): string {
    return $this->des_trans;
}

public function setCodObj(int $cod_obj): void {
    $this->cod_obj = $cod_obj;
}

public function getCodObj(): int {
    return $this->cod_obj;
}

public function setNomObj(string $nom_obj): void {
    $this->nom_obj = $nom_obj;
}

public function getNomObj(): string {
    return $this->nom_obj;
}

public function setCodUsuario(int $cod_Usuario): void {
    $this->cod_usuario = $cod_Usuario;
}

public function getCodUsuario(): int {
    return $this->cod_Usuario;
}

public function setFecSis(): void {
    $this->fec_sis = new \DateTime();
}

public function getFecSis(): DateTime {
    return $this->fec_sis;
}

public function setIpUsuario(string $ip_usuario): void {
    $this->ip_usuario = $ip_usuario;
}

public function getIpUsuario(): string {
    return $this->ip_usuario;
}
}

        