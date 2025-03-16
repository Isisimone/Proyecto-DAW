<?php

namespace Clases;

class Marcaje{
    //Atributos
    private int $cod_Marcaje;
    private int $cod_Tipo_Marcaje;
    private int $cod_Empleado;
    private int $cod_bio;
    private DateTime $fec_Marcaje;
    private DateTime $fec_Grabacion;
    private bool $incidencia;
    private bool $pendiente;
    private string $foto;
    private string $tipoAcceso;
    private string $obs;
    private string $nom_Usuario_Alta;

    //Método constructor
    public function __construct(
        int $cod_Marcaje,
        int $cod_Tipo_Marcaje,
        int $cod_Empleado,
        int $cod_bio,
        DateTime $fec_Marcaje,
        DateTime $fec_Grabacion,
        bool $incidencia,
        bool $pendiente,
        string $foto,
        string $tipoAcceso,
        string $obs,
        string $nom_Usuario_Alta
    ) {
        $this->cod_Marcaje = $cod_Marcaje;
        $this->cod_Tipo_Marcaje = $cod_Tipo_Marcaje;
        $this->cod_Empleado = $cod_Empleado;
        $this->cod_bio = $cod_bio;
        $this->fec_Marcaje = $fec_Marcaje;
        $this->fec_Grabacion = $fec_Grabacion;
        $this->incidencia = $incidencia;
        $this->pendiente = $pendiente;
        $this->foto = $foto;
        $this->tipoAcceso = $tipoAcceso;
        $this->obs = $obs;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

    // Getters
    public function getCodMarcaje(): int {
        return $this->cod_Marcaje;
    }

    public function getCodTipoMarcaje(): int {
        return $this->cod_Tipo_Marcaje;
    }

    public function getCodEmpleado(): int {
        return $this->cod_Empleado;
    }

    public function getCodBio(): int {
        return $this->cod_bio;
    }

    public function getFecMarcaje(): DateTime {
        return $this->fec_Marcaje;
    }

    public function getFecGrabacion(): DateTime {
        return $this->fec_Grabacion;
    }

    public function getIncidencia(): bool {
        return $this->incidencia;
    }

    public function getPendiente(): bool {
        return $this->pendiente;
    }

    public function getFoto(): string {
        return $this->foto;
    }

    public function getTipoAcceso(): string {
        return $this->tipoAcceso;
    }

    public function getObs(): string {
        return $this->obs;
    }

    public function getNomUsuarioAlta(): string {
        return $this->nom_Usuario_Alta;
    }

    // Setters

    public function setCodMarcaje(int $cod_Marcaje): void {
        $this->cod_Marcaje = $cod_Marcaje;
    }

    public function setCodTipoMarcaje(int $cod_Tipo_Marcaje): void {
        $this->cod_Tipo_Marcaje = $cod_Tipo_Marcaje;
    }

    public function setCodEmpleado(int $cod_Empleado): void {
        $this->cod_Empleado = $cod_Empleado;
    }

    public function setCodBio(int $cod_bio): void {
        $this->cod_bio = $cod_bio;
    }

    public function setFecMarcaje(DateTime $fec_Marcaje): void {
        $this->fec_Marcaje = $fec_Marcaje;
    }

    public function setFecGrabacion(DateTime $fec_Grabacion): void {
        $this->fec_Grabacion = $fec_Grabacion;
    }

    public function setIncidencia(bool $incidencia): void {
        $this->incidencia = $incidencia;
    }

    public function setPendiente(bool $pendiente): void {
        $this->pendiente = $pendiente;
    }

    public function setFoto(string $foto): void {
        $this->foto = $foto;
    }

    public function setTipoAcceso(string $tipoAcceso): void {
        $this->tipoAcceso = $tipoAcceso;
    }

    public function setObs(string $obs): void {
        $this->obs = $obs;
    }

    public function setNomUsuarioAlta(string $nom_Usuario_Alta): void {
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

    //Destructor
    public function __destruct() {
        unset($this->cod_Marcaje);
        unset($this->cod_Tipo_Marcaje);
        unset($this->cod_Empleado);
        unset($this->cod_bio);
        unset($this->fec_Marcaje);
        unset($this->fec_Grabacion);
        unset($this->incidencia);
        unset($this->pendiente);
        unset($this->foto);
        unset($this->tipoAcceso);
        unset($this->obs);
        unset($this->nom_Usuario_Alta);
    }

    //Método para registrar el marcaje en la bbdd
    public function grabar(): bool {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("INSERT INTO tmarcaje VALUES (:cod_Tipo_Marcaje, :cod_Empleado, :cod_bio, :fec_Marcaje, :fec_Grabacion, :incidencia, :pendiente, :foto, :tipoAcceso, :obs, :nom_Usuario_Alta)");
        $cod_Tipo_Marcaje = $this->getCodTipoMarcaje();
        $cod_Empleado = $this->getCodEmpleado();
        $cod_bio = $this->getCodBio();
        $fec_Marcaje = $this->getFecMarcaje();
        $fec_Grabacion = $this->getFecGrabacion();
        $incidencia = $this->getIncidencia();
        $pendiente = $this->getPendiente();
        $foto = $this->getFoto();
        $tipoAcceso = $this->getTipoAcceso();
        $obs = $this->getObs();
        $nom_Usuario_Alta = $this->getNomUsuarioAlta();
        $consulta->bindParam(':cod_Tipo_Marcaje', $cod_Tipo_Marcaje);
        $consulta->bindParam(':cod_Empleado', $cod_Empleado);
        $consulta->bindParam(':cod_bio', $cod_bio);
        $consulta->bindParam(':fec_Marcaje', $fec_Marcaje);
        $consulta->bindParam(':fec_Grabacion', $fec_Grabacion);
        $consulta->bindParam(':incidencia', $incidencia);
        $consulta->bindParam(':pendiente', $pendiente);
        $consulta->bindParam(':foto', $foto);
        $consulta->bindParam(':tipoAcceso', $tipoAcceso);
        $consulta->bindParam(':obs', $obs);
        $consulta->bindParam(':nom_Usuario_Alta', $nom_Usuario_Alta);
        $consulta->execute();
        $conexion = null;
        return true;
    }

    //Método para cargar los datos de un marcaje
    public function cargarDatosMarcaje(int $cod_Marcaje): void {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("SELECT * FROM tmarcaje WHERE COD_MARCAJE = :cod_Marcaje");
        $consulta->bindParam(':cod_Marcaje', $cod_Marcaje);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if (!$resultado) {
            return;
        }
        $this->cod_Marcaje = $resultado['COD_MARCAJE'];
        $this->cod_Tipo_Marcaje = $resultado['COD_TIPO_MARCAJE'];
        $this->cod_Empleado = $resultado['COD_EMPLEADO'];
        $this->cod_bio = $resultado['COD_BIO'];
        $this->fec_Marcaje = $resultado['FEC_MARCAJE'];
        $this->fec_Grabacion = $resultado['FEC_GRABACION'];
        $this->incidencia = $resultado['INCIDENCIA'];
        $this->pendiente = $resultado['PENDIENTE'];
        $this->foto = $resultado['FOTO'];
        $this->tipoAcceso = $resultado['TIPO_ACCESO'];
        $this->obs = $resultado['OBS'];
        $this->nom_Usuario_Alta = $resultado['NOM_USUARIO_ALTA'];
    }

}