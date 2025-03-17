<?php

namespace Clases;

use DateTime;
use PDO;
use PDOException;

class Marcaje{
    //Atributos
    private int $cod_Marcaje;
    private int $cod_Tipo_Marcaje;
    private int $cod_Empleado;
    private int $cod_bio;
    private DateTime $fec_Marcaje;
    private DateTime $fec_Grabacion;
    private DateTime $hor_Marcaje;
    private DateTime $hor_Grabacion;
    private bool $incidencia;
    private bool $pendiente;
    private string $foto;
    private string $tipoAcceso;
    private string $obs;

    //Método constructor
    public function __construct(){        
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
    }

    //Método para registrar el marcaje en la bbdd
    public function grabar(): bool {
        $conexion = new Conexion();
        $consulta = $conexion->conexion->prepare("INSERT INTO tmarcaje (COD_TIPO_MARCAJE, COD_EMPLEADO, COD_BIO, DES_FOTO, FEC_MARCAJE, HOR_MARCAJE, FEC_GRABACION, HOR_GRABACION, IND_INCIDENCIA, IND_PENDIENTE, COD_TIPO_ACCESO, DES_OBSERVACIONES) VALUES (:COD_TIPO_MARCAJE, :COD_EMPLEADO, :COD_BIO, :DES_FOTO, :FEC_MARCAJE, :HOR_MARCAJE, :FEC_GRABACION, :HOR_GRABACION, :IND_INCIDENCIA, :IND_PENDIENTE, :COD_TIPO_ACCESO, :DES_OBSERVACIONES)");
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
        $consulta->bindValue(':COD_TIPO_MARCAJE', $cod_Tipo_Marcaje);
        $consulta->bindValue(':COD_EMPLEADO', $cod_Empleado);
        $consulta->bindValue(':COD_BIO', $cod_bio);
        $consulta->bindValue(':DES_FOTO', $foto);
        $consulta->bindValue(':FEC_MARCAJE', $fec_Marcaje->format('Y-m-d'));
        $consulta->bindValue(':HOR_MARCAJE', $fec_Marcaje->format('H:i:s'));
        $consulta->bindValue(':FEC_GRABACION', $fec_Grabacion->format('Y-m-d'));
        $consulta->bindValue(':HOR_GRABACION', $fec_Grabacion->format('H:i:s'));
        $consulta->bindValue(':IND_INCIDENCIA', $incidencia);
        $consulta->bindValue(':IND_PENDIENTE', $pendiente);
        $consulta->bindValue(':COD_TIPO_ACCESO', $tipoAcceso);
        $consulta->bindValue(':DES_OBSERVACIONES', $obs);
        $consulta->execute();
        $conexion = null;
        return true;
    }

    //Método para cargar los datos de un marcaje
    public function cargar(int $cod_Marcaje): Marcaje {
        $conexion = new Conexion();
        $consulta = $conexion->conexion->prepare("SELECT * FROM tmarcaje WHERE COD_MARCAJE = :cod_Marcaje");
        $consulta->bindParam(':cod_Marcaje', $cod_Marcaje);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if (!$resultado) {
            return null;
        }
        $this->cod_Marcaje = $resultado['COD_MARCAJE'];
        $this->cod_Tipo_Marcaje = $resultado['COD_TIPO_MARCAJE'];
        $this->cod_Empleado = $resultado['COD_EMPLEADO'];
        $this->cod_bio = $resultado['COD_BIO'];
        $this->fec_Marcaje = new DateTime($resultado['FEC_MARCAJE']);
        $this->hor_Marcaje = new DateTime($resultado['HOR_MARCAJE']);
        $this->fec_Grabacion = new DateTime($resultado['FEC_GRABACION']);
        $this->hor_Grabacion = new DateTime($resultado['HOR_GRABACION']);
        $this->incidencia = $resultado['IND_INCIDENCIA'];
        $this->pendiente = $resultado['IND_PENDIENTE'];
        $this->foto = $resultado['DES_FOTO'];
        $this->tipoAcceso = $resultado['COD_TIPO_ACCESO'];
        $this->obs = $resultado['DES_OBSERVACIONES'];
        return $this;
    }

        //Método para cargar conjunto de marcajes entre fechas
        public function cargarMarcajesEntreFechas(DateTime $fechaInicio, DateTime $fechaFin): array {
            $conexion = new Conexion();
            $consulta = $conexion->conexion->prepare("SELECT * FROM tmarcaje WHERE FEC_MARCAJE BETWEEN :fechaInicio AND :fechaFin");
            $consulta->bindValue(':fechaInicio', $fechaInicio->format('Y-m-d'));
            $consulta->bindValue(':fechaFin', $fechaFin->format('Y-m-d'));
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $marcajes = [];
            foreach ($resultado as $marcaje) {
            $marcajeObj = new Marcaje();
            $marcajeObj->setCodMarcaje($marcaje['COD_MARCAJE']);
            $marcajeObj->setCodTipoMarcaje($marcaje['COD_TIPO_MARCAJE']);
            $marcajeObj->setCodEmpleado($marcaje['COD_EMPLEADO']);
            $marcajeObj->setCodBio($marcaje['COD_BIO']);
            $marcajeObj->setFecMarcaje(new DateTime($marcaje['FEC_MARCAJE']));
            $marcajeObj->setFecGrabacion(new DateTime($marcaje['FEC_GRABACION']));
            $marcajeObj->setIncidencia($marcaje['IND_INCIDENCIA']);
            $marcajeObj->setPendiente($marcaje['IND_PENDIENTE']);
            $marcajeObj->setFoto($marcaje['DES_FOTO']);
            $marcajeObj->setTipoAcceso($marcaje['COD_TIPO_ACCESO']);
            $marcajeObj->setObs($marcaje['DES_OBSERVACIONES']);
            $marcajes[] = $marcajeObj;
            }
            return $marcajes;
        }
}