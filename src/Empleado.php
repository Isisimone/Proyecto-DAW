<?php

namespace Clases;

class Empleado{
    // Atributos
    private int $cod_Empleado;
    private int $cod_Usuario;
    private string $nombre;
    private string $apellido1;
    private string $apellido2;
    private string $contacto;
    private date $fec_Alta;
    private string $nom_Usuario_Alta;
    private ?date $fec_Baja;
    private ?string $nom_Usuario_Baja;

    //Método constructor
    public function __construct(
        int $cod_Empleado,
        int $cod_Usuario,
        string $nombre,
        string $apellido1,
        string $apellido2,
        string $contacto,
        date $fec_Alta,
        string $nom_Usuario_Alta,
        ?date $fec_Baja = null,
        ?string $nom_Usuario_Baja = null
    ) {
        $this->cod_Empleado = $cod_Empleado;
        $this->cod_Usuario = $cod_Usuario;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->contacto = $contacto;
        $this->fec_Alta = $fec_Alta;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
        $this->fec_Baja = $fec_Baja;
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
    }

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

    public function getFecAlta(): date {
        return $this->fec_Alta;
    }

    public function getNomUsuarioAlta(): string {
        return $this->nom_Usuario_Alta;
    }

    public function getFecBaja(): ?date {
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

    public function setFecAlta(date $fec_Alta): void {
        $this->fec_Alta = $fec_Alta;
    }

    public function setNomUsuarioAlta(string $nom_Usuario_Alta): void {
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

    //Método para cargar datos de la bbdd
    public function cargarDatosEmpleado(int $cod_Empleado): void {
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "SELECT * FROM templeado WHERE COD_BIO = :cod_bio";
        // Preparar la sentencia
        $stmt = $conexion->getConexion()->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_bio', $cod_bio, PDO::PARAM_INT);
        // Ejecutar la sentencia
        $stmt->execute();
        // Obtener el resultado de la sentencia
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Si no hay resultado, devolver null
        if (!$resultado) {
            return;
        }
        //Asigna los atributos al objeto
        $this->cod_Empleado = $resultado['COD_EMPLEADO'];
        $this->cod_Usuario = $resultado['COD_USUARIO'];
        $this->nombre = $resultado['NOM_EMPLEADO'];
        $this->apellido1 = $resultado['APE1_EMPLEADO'];
        $this->apellido2 = $resultado['APE2_EMPLEADO'];
        $this->contacto = $resultado['CONTACTO_EMPLEADO'];
        $this->fec_Alta = $resultado['FEC_ALTA'];
        $this->nom_Usuario_Alta = $resultado['NOM_USUARIO_ALTA'];
        $this->fec_Baja = $resultado['FEC_BAJA'];
        $this->nom_Usuario_Baja = $resultado['NOM_USUARIO_BAJA'];

            
    }

    //Método para grabar en la base de datos un nuevo registro a partir del objeto
    public function grabar(): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "INSERT INTO templeado (COD_EMPLEADO, COD_USUARIO, NOM_EMPLEADO, APE1_EMPLEADO, APE2_EMPLEADO, CONTACTO_EMPLEADO, FEC_ALTA, NOM_USUARIO_ALTA, FEC_BAJA, NOM_USUARIO_BAJA) VALUES (:cod_Empleado, :cod_Usuario, :nombre, :apellido1, :apellido2, :contacto, :fec_Alta, :nom_Usuario_Alta, :fec_Baja, :nom_Usuario_Baja)";
        // Preparar la sentencia
        $stmt = $conexion->getConexion()->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
        $stmt->bindValue(':cod_Usuario', $this->cod_Usuario, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellido1', $this->apellido1, PDO::PARAM_STR);
        $stmt->bindValue(':apellido2', $this->apellido2, PDO::PARAM_STR);
        $stmt->bindValue(':contacto', $this->contacto, PDO::PARAM_STR);
        $stmt->bindValue(':fec_Alta', $this->fec_Alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':nom_Usuario_Alta', $this->nom_Usuario_Alta, PDO::PARAM_STR);
        $stmt->bindValue(':fec_Baja', $this->fec_Baja, PDO::PARAM_STR);
        $stmt->bindValue(':nom_Usuario_Baja', $this->nom_Usuario_Baja, PDO::PARAM_STR);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver el resultado de la sentencia
        return $stmt->rowCount() > 0;
    }

    //Método para dar de baja a un empleado a partir del usuario pasado por parámetro y la fecha de baja
    public function darBaja(string $nom_Usuario_Baja, date $fec_Baja): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "UPDATE templeado SET FEC_BAJA = :fec_Baja, NOM_USUARIO_BAJA = :nom_Usuario_Baja WHERE COD_EMPLEADO = :cod_Empleado";
        // Preparar la sentencia
        $stmt = $conexion->getConexion()->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
        $stmt->bindValue(':fec_Baja', $fec_Baja->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':nom_Usuario_Baja', $nom_Usuario_Baja, PDO::PARAM_STR);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver el resultado de la sentencia
        return $stmt->rowCount() > 0;
    }

    //Método para modificar un empleado a partir del objeto
    public function modificar(): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Crear la sentencia SQL
        $sql = "UPDATE templeado SET COD_USUARIO = :cod_Usuario, NOM_EMPLEADO = :nombre, APE1_EMPLEADO = :apellido1, APE2_EMPLEADO = :apellido2, CONTACTO_EMPLEADO = :contacto WHERE COD_EMPLEADO = :cod_Empleado";
        // Preparar la sentencia
        $stmt = $conexion->getConexion()->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindValue(':cod_Empleado', $this->cod_Empleado, PDO::PARAM_INT);
        $stmt->bindValue(':cod_Usuario', $this->cod_Usuario, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellido1', $this->apellido1, PDO::PARAM_STR);
        $stmt->bindValue(':apellido2', $this->apellido2, PDO::PARAM_STR);
        $stmt->bindValue(':contacto', $this->contacto, PDO::PARAM_STR);
        // Ejecutar la sentencia
        $stmt->execute();
        // Devolver el resultado de la sentencia
        return $stmt->rowCount() > 0;
    }



    
}