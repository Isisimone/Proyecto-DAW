<?php

namespace Clases;

class Transaccion{
    // Atributos
    private int $cod_Transaccion;
    private int $tipo_Trans;
    private string $des_trans;
    private int $cod_Obj;
    private string $nom_Obj;
    private int $cod_Usuario;
    private DateTime $fec_Sis;
    private string $ip_Usuario;

    // Constructor sin parámetros
    public function __construct() {
    
    }

    // set y get
    public function setCodTransaccion(int $cod_Transaccion): void {
        $this->cod_Transaccion = $cod_Transaccion;
    }

    public function getCodTransaccion(): int {
        return $this->cod_Transaccion;
    }

    public function setTipoTrans(int $tipo_Trans): void {
        $this->tipo_Trans = $tipo_Trans;
    }

    public function getTipoTrans(): int {
        return $this->tipo_Trans;
    }

    public function setDesTrans(string $des_trans): void {
        $this->des_trans = $des_trans;
    }

    public function getDesTrans(): string {
        return $this->des_trans;
    }

    public function setCodObj(int $cod_Obj): void {
        $this->cod_Obj = $cod_Obj;
    }

    public function getCodObj(): int {
        return $this->cod_Obj;
    }

    public function setNomObj(string $nom_Obj): void {
        $this->nom_Obj = $nom_Obj;
    }

    public function getNomObj(): string {
        return $this->nom_Obj;
    }

    public function setCodUsuario(int $cod_Usuario): void {
        $this->cod_Usuario = $cod_Usuario;
    }

    public function getCodUsuario(): int {
        return $this->cod_Usuario;
    }

    public function setFecSis(): void {
        $this->fec_Sis = new \DateTime();
    }

    public function getFecSis(): DateTime {
        return $this->fec_Sis;
    }

    public function setIpUsuario(string $ip_Usuario): void {
        $this->ip_Usuario = $ip_Usuario;
    }

    public function getIpUsuario(): string {
        return $this->ip_Usuario;
    }

//Método crear transaccion que escribe en la bbdd a partir del objeto
    public function crearTransaccion(): void {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO ttransacciones (TIP_TRANS, DESC_TRANS, COD_OBJ, NOM_OBJ, COD_USUARIO, FEC_SIS, HOR_SIS, IP_USUARIO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('isisisss',
        $this->tipo,
        $this->descripcion,
        $this->cod_Obj,
        $this->nom_Obj,
        $this->cod_Usuario,
        $this->fec_Sis,
        $this->hor_Sis,
        $this->ip_Usuario);
        $stmt->execute();
        $stmt->close();
        $conexion->cerrar();
        return;
    }

    //Método para obtener transacciones de la bbdd
    public function obtenerTransacciones(): array {
        $transacciones = [];
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM ttransacciones";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $transacciones[] = $fila;
            }
        }
        $conexion->cerrar();
        return $transacciones;
    }

    //Método para obtener transacciones de la bbdd a partir del código de usuario
    public function obtenerTransaccionesUsuario(int $cod_Usuario): array {
        $transacciones = [];
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM ttransacciones WHERE COD_USUARIO = $cod_Usuario";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $transacciones[] = $fila;
            }
        }
        $conexion->cerrar();
        return $transacciones;
    }

    //Método para obtener transacciones de la bbdd entre 2 fechas
    public function obtenerTransaccionesEntreFechas(DateTime $fec_Ini, DateTime $fec_Fin): array {
        $transacciones = [];
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM ttransacciones WHERE FEC_SIS BETWEEN $fec_Ini AND $fec_Fin";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $transacciones[] = $fila;
            }
        }
        $conexion->cerrar();
        return $transacciones;
    }
}

        