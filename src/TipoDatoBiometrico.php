<?php

namespace Clases;

class DatosBiometricos{
    //Atributos
    private int $cod_bio;
    private int $cod_Empleado;
    private int $cod_Tipo;
    private string $dato_Bio;
    private DateTime $fec_Alta;
    private string $nom_Usuario_Alta;

    //Método constructor
    public function __construct(
        int $cod_bio,
        int $cod_Empleado,
        int $cod_Tipo,
        string $dato_Bio,
        DateTime $fec_Alta,
        string $nom_Usuario_Alta
    ) {
        $this->cod_bio = $cod_bio;
        $this->cod_Empleado = $cod_Empleado;
        $this->cod_Tipo = $cod_Tipo;
        $this->dato_Bio = $dato_Bio;
        $this->fec_Alta = $fec_Alta;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

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

    //Método para obtener los datos biometricos de un empleado
    public function obtenerDatosBiometricosEmpleado(int $cod_Empleado): array {
        $datosBiometricos = [];
        $sql = "SELECT * FROM tbio WHERE cod_Empleado = $cod_Empleado";
        $resultado = $this->conexion->query($sql);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $datosBiometricos[] = $fila;
            }
        }
        return $datosBiometricos;
    }

    //Método para grabar en la base de datos un nuevo registro a partir del objeto
    public function grabar(): bool {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("INSERT INTO tbio VALUES (:cod_bio, :cod_Empleado, :cod_Tipo, :dato_Bio, :fec_Alta, :nom_Usuario_Alta)");
        $cod_bio = $this->getCodBio();
        $cod_Empleado = $this->getCodEmpleado();
        $cod_Tipo = $this->getCodTipo();
        $dato_Bio = $this->getDatoBio();
        $fec_Alta = $this->getFecAlta();
        $nom_Usuario_Alta = $this->getNomUsuarioAlta();
        $consulta->bindParam(':cod_bio', $cod_bio);
        $consulta->bindParam(':cod_Empleado', $cod_Empleado);
        $consulta->bindParam(':cod_Tipo', $cod_Tipo);
        $consulta->bindParam(':dato_Bio', $dato_Bio);
        $consulta->bindParam(':fec_Alta', $fec_Alta);
        $consulta->bindParam(':nom_Usuario_Alta', $nom_Usuario_Alta);
        $consulta->execute();
        $conexion = null;
        return true;
    }

    //Método para cargar los datos de un registro de datos biometricos
    public function cargarDatosBiometricos(int $cod_bio): void {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("SELECT * FROM tbio WHERE cod_bio = :cod_bio");
        $consulta->bindParam(':cod_bio', $cod_bio);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $this->setCodBio($resultado['cod_bio']);
        $this->setCodEmpleado($resultado['cod_Empleado']);
        $this->setCodTipo($resultado['cod_Tipo']);
        $this->setDatoBio($resultado['dato_Bio']);
        $this->setFecAlta($resultado['fec_Alta']);
        $this->setNomUsuarioAlta($resultado['nom_Usuario_Alta']);
    }

    //Método para eliminar un registro de datos biométricos
    public function eliminarDatosBiometricos(int $cod_bio): bool {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("DELETE FROM tbio WHERE cod_bio = :cod_bio");
        $consulta->bindParam(':cod_bio', $cod_bio);
        $consulta->execute();
        $conexion = null;
        return true;
    }

    
}