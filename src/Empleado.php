<?php

namespace Clases;

use DateTime;
use PDO;
use PDOException;

class Empleado {
    // Atributos
    private int $cod_Empleado;
    private int $cod_Usuario;
    private string $nombre;
    private string $apellido1;
    private string $apellido2;
    private string $contacto;
    private DateTime $fec_Alta;
    private string $nom_Usuario_Alta;
    private ?DateTime $fec_Baja;
    private ?string $nom_Usuario_Baja;

    // Método constructor
    public function __construct() {
        $this->cod_Empleado= 0;
        $this->fec_Baja = null;
        $this->nom_Usuario_Baja = null;
    }



    // Método para cargar datos de un determinado empleado de la base de datos
    public function cargarDatosEmpleado(int $cod_Empleado): bool {
        try {
            $conexion = new Conexion();
            $sql = "SELECT * FROM templeado WHERE COD_EMPLEADO = :cod_Empleado";
            $stmt = $conexion->conexion->prepare($sql);
            $stmt->bindValue(':cod_Empleado', $cod_Empleado, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                return false;
            }

            $this->cod_Empleado = $resultado['COD_EMPLEADO'];
            $this->cod_Usuario = $resultado['COD_USUARIO'];
            $this->nombre = $resultado['NOM_EMPLEADO'];
            $this->apellido1 = $resultado['APE1_EMPLEADO'];
            $this->apellido2 = $resultado['APE2_EMPLEADO'];
            $this->contacto = $resultado['CONTACTO_EMPLEADO'];
            $this->fec_Alta = new DateTime($resultado['FEC_ALTA']);
            $this->nom_Usuario_Alta = $resultado['NOM_USUARIO_ALTA'];
            $this->fec_Baja = $resultado['FEC_BAJA'] ? new DateTime($resultado['FEC_BAJA']) : null;
            $this->nom_Usuario_Baja = $resultado['NOM_USUARIO_BAJA'] ?? null;

            return true;
        } catch (PDOException $e) {
            // Manejo de excepciones
            error_log("Error al cargar datos del empleado: " . $e->getMessage());
            return false;
        }
    }

    // Método para grabar un nuevo empleado en la base de datos
    public function grabar(): bool {
        try {
            $conexion = new Conexion();
            if ($this->cod_Empleado==0 || is_null($this->cod_Empleado)){
                $sql = "INSERT INTO templeado (COD_USUARIO, NOM_EMPLEADO, APE1_EMPLEADO, APE2_EMPLEADO, CONTACTO_EMPLEADO, FEC_ALTA, NOM_USUARIO_ALTA, FEC_BAJA, NOM_USUARIO_BAJA) 
                    VALUES (:cod_Usuario, :nombre, :apellido1, :apellido2, :contacto, :fec_Alta, :nom_Usuario_Alta, :fec_Baja, :nom_Usuario_Baja)";
                $stmt = $conexion->conexion->prepare($sql);
            } else{
                $sql = "UPDATE templeado SET COD_USUARIO = :cod_Usuario, NOM_EMPLEADO = :nombre, APE1_EMPLEADO = :apellido1, APE2_EMPLEADO = :apellido2, CONTACTO_EMPLEADO = :contacto 
                , FEC_ALTA = :fec_Alta, NOM_USUARIO_ALTA = :nom_Usuario_Alta, FEC_BAJA=:fec_Baja, NOM_USUARIO_BAJA = :nom_Usuario_Baja
                WHERE COD_EMPLEADO = :cod_Empleado";
                $stmt = $conexion->conexion->prepare($sql);
                $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
            }
            $stmt->bindValue(':cod_Usuario', $this->cod_Usuario, PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido1', $this->apellido1, PDO::PARAM_STR);
            $stmt->bindValue(':apellido2', $this->apellido2, PDO::PARAM_STR);
            $stmt->bindValue(':contacto', $this->contacto, PDO::PARAM_STR);
            $stmt->bindValue(':fec_Alta', $this->fec_Alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':nom_Usuario_Alta', $this->nom_Usuario_Alta, PDO::PARAM_STR);
            $stmt->bindValue(':fec_Baja', $this->fec_Baja ? $this->fec_Baja->format('Y-m-d H:i:s') : null, PDO::PARAM_STR);
            $stmt->bindValue(':nom_Usuario_Baja', $this->nom_Usuario_Baja, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al grabar empleado: " . $e->getMessage());
            return false;
        }
    }

    // Método para dar de baja a un empleado
    public function darBaja(string $nom_Usuario_Baja, DateTime $fec_Baja): bool {
        try {
            $conexion = new Conexion();
            $sql = "UPDATE templeado SET FEC_BAJA = :fec_Baja, NOM_USUARIO_BAJA = :nom_Usuario_Baja WHERE COD_EMPLEADO = :cod_Empleado";
            $stmt = $conexion->conexion->prepare($sql);
            $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
            $stmt->bindValue(':fec_Baja', $fec_Baja->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':nom_Usuario_Baja', $nom_Usuario_Baja, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al dar de baja al empleado: " . $e->getMessage());
            return false;
        }
    }

    // Método para modificar el empleado actual
    public function modificar(): bool {
        try {
            $conexion = new Conexion();
            
            $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
            $stmt->bindValue(':cod_Usuario', $this->cod_Usuario, PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido1', $this->apellido1, PDO::PARAM_STR);
            $stmt->bindValue(':apellido2', $this->apellido2, PDO::PARAM_STR);
            $stmt->bindValue(':contacto', $this->contacto, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al modificar empleado: " . $e->getMessage());
            return false;
        }
    }

    // Método para listar todos los empleados
    public function listarEmpleados() {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM templeado";
            // Ejecuto la consulta
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->execute();
            // Devuelvo el resultado de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar empleados: " . $e->getMessage());
            return [];
        }
    }

    // Método para eliminar el empelado actual en la BBDD, solo para pruebas
    public function eliminar(): bool {
        try {
            $conexion = new Conexion();
            $sql = "DELETE FROM templeado WHERE COD_EMPLEADO = :cod_Empleado";
            $stmt = $conexion->conexion->prepare($sql);
            $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar empleado: " . $e->getMessage());
            return false;
        }
    }

/*
<<<<<<<<<<<<<<<<<<<<<<<<<GETTERS Y SETTERS>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
*/
        // Getters
        public function getCodEmpleado(): int {
            return $this->cod_Empleado;
        }
    
        public function getCodUsuario(): int {
            return $this->cod_Usuario;
        }
    
        public function getNombre(): string {
            return $this->nombre;
        }
    
        public function getApellido1(): string {
            return $this->apellido1;
        }
    
        public function getApellido2(): string {
            return $this->apellido2;
        }
    
        public function getContacto(): string {
            return $this->contacto;
        }
    
        public function getFecAlta(): DateTime {
            return $this->fec_Alta;
        }
    
        public function getNomUsuarioAlta(): string {
            return $this->nom_Usuario_Alta;
        }
    
        public function getFecBaja(): ?DateTime {
            return $this->fec_Baja;
        }
    
        public function getNomUsuarioBaja(): ?string {
            return $this->nom_Usuario_Baja;
        }
    
        // Setters
        public function setCodEmpleado(int $cod_Empleado): void {
            $this->cod_Empleado = $cod_Empleado;
        }
    
        public function setCodUsuario(int $cod_Usuario): void {
            $this->cod_Usuario = $cod_Usuario;
        }
    
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }
    
        public function setApellido1(string $apellido1): void {
            $this->apellido1 = $apellido1;
        }
    
        public function setApellido2(string $apellido2): void {
            $this->apellido2 = $apellido2;
        }
    
        public function setContacto(string $contacto): void {
            $this->contacto = $contacto;
        }
    
        public function setFecAlta(DateTime $fec_Alta): void {
            $this->fec_Alta = $fec_Alta;
        }
    
        public function setNomUsuarioAlta(string $nom_Usuario_Alta): void {
            $this->nom_Usuario_Alta = $nom_Usuario_Alta;
        }
}