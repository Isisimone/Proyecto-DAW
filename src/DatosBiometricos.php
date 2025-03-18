<?php

namespace Clases;
use DateTime;
use PDO;            //Librerías PDO
use PDOException;

class DatosBiometricos{

    // Atributos
    private int $cod_bio;
    private int $cod_Empleado;
    private int $cod_Tipo;
    private string $dato_Bio;
    private DateTime $fec_Alta;
    private string $nom_Usuario_Alta;

    

    // Constructor
    public function __construct() {
    }

    

   //Método para grabar en la base de datos un nuevo registro a partir del objeto
    public function grabar(): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "INSERT INTO tbio (COD_EMPLEADO, COD_TIPO_BIO, DATO_BIO, FEC_ALTA, NOM_USUARIO_ALTA) VALUES (:cod_Empleado, :cod_Tipo, :dato_Bio, :fec_Alta, :nom_Usuario_Alta)";
        // Preparar la sentencia
        $stmt = $conexion->conexion->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
        $stmt->bindValue(':cod_Tipo', $this->cod_Tipo, PDO::PARAM_INT);
        $stmt->bindValue(':dato_Bio', $this->dato_Bio, PDO::PARAM_STR);
        $stmt->bindValue(':fec_Alta', $this->fec_Alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':nom_Usuario_Alta', $this->nom_Usuario_Alta, PDO::PARAM_STR);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver el resultado de la sentencia
        return $stmt->rowCount() > 0;
    }

    //Método para eliminar un registro de la base de datos a partir del objeto
    public function eliminar(): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "DELETE FROM tbio WHERE COD_BIO = :cod_bio";
        // Preparar la sentencia
        $stmt = $conexion->conexion->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_bio', $this->cod_bio, PDO::PARAM_INT);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver el resultado de la sentencia
        return $stmt->rowCount() > 0;
    }

    //Método para cargar de la base de datos un registro a partir del código
    public static function cargar(int $cod_bio): ?DatosBiometricos {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "SELECT * FROM tbio WHERE COD_BIO = :cod_bio";
        // Preparar la sentencia
        $stmt = $conexion->conexion->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_bio', $cod_bio, PDO::PARAM_INT);
        // Ejecutar la sentencia
        $stmt->execute();
        // Obtener el resultado de la sentencia
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Si no hay resultado, devolver null
        if (!$resultado) {
            return null;
        }
    
        // Crear una instancia de DatosBiometricos
        $datosBiometricos = new DatosBiometricos();
    
        // Asignar los valores a los atributos del objeto
        $datosBiometricos->setCodBio($resultado['COD_BIO']);
        $datosBiometricos->setCodEmpleado($resultado['COD_EMPLEADO']);
        $datosBiometricos->setCodTipo($resultado['COD_TIPO_BIO']);
        $datosBiometricos->setDatoBio($resultado['DATO_BIO']);
        $datosBiometricos->setFecAlta(new DateTime($resultado['FEC_ALTA']));
        $datosBiometricos->setNomUsuarioAlta($resultado['NOM_USUARIO_ALTA']);
    
        // Devolver la instancia de DatosBiometricos
        return $datosBiometricos;
    }

//<<<<<<<<<<<<<<<<<<<<< GETTERS Y SETTERS >>>>>>>>>>>>>>>>>>>>>>>>>>

    // Getters
public function getCodBio(): int {
    return $this->cod_bio;
}

public function getCodEmpleado(): int {
    return $this->cod_Empleado;
}

public function getCodTipo(): int {
    return $this->cod_Tipo;
}

public function getDatoBio(): string {
    return $this->dato_Bio;
}

public function getFecAlta(): DateTime {
    return $this->fec_Alta;
}

public function getNomUsuarioAlta(): string {
    return $this->nom_Usuario_Alta;
}

// Setters
public function setCodBio(int $cod_bio): void {
    $this->cod_bio = $cod_bio;
}

public function setCodEmpleado(int $cod_Empleado): void {
    $this->cod_Empleado = $cod_Empleado;
}

public function setCodTipo(int $cod_Tipo): void {
    $this->cod_Tipo = $cod_Tipo;
}

public function setDatoBio(string $dato_Bio): void {
    $this->dato_Bio = $dato_Bio;
}

public function setFecAlta(DateTime $fec_Alta): void {
    $this->fec_Alta = $fec_Alta;
}

public function setNomUsuarioAlta(string $nom_Usuario_Alta): void {
    $this->nom_Usuario_Alta = $nom_Usuario_Alta;
}
}