<?php

namespace Clases;
use PDO;
use PDOException;
use DateTime;

class TipoDatoBiometrico{
    //Atributos
    private int $cod_tipo_bio;
    private string $des_tipo_bio;
    private DateTime $fec_Alta;
    private string $nom_Usuario_Alta;
    private ?DateTime $fec_Baja;
    private ?string $nom_Usuario_Baja;

    //Método constructor
    public function __construct() {
        $this->cod_tipo_bio=0;
        $this->fec_Baja = null;
        $this->nom_Usuario_Baja = null;
    }

    
    //Método para grabar en la base de datos un nuevo registro a partir del objeto
    public function grabar(): bool {
        $conexion = new Conexion();
        if ($this->cod_tipo_bio == 0 || is_null($this->cod_tipo_bio)) {
            $consulta = $conexion->conexion->prepare("INSERT INTO ttbio (DES_TIPO_BIO, FEC_ALTA, NOM_USUARIO_ALTA, FEC_BAJA, NOM_USUARIO_BAJA) VALUES (:des_tipo_bio, :fec_Alta, :nom_Usuario_Alta, :fec_Baja, :nom_Usuario_Baja)");
        } else {
            $consulta = $conexion->conexion->prepare("UPDATE ttbio SET DES_TIPO_BIO = :des_tipo_bio, FEC_BAJA = :fec_Baja, NOM_USUARIO_BAJA = :nom_Usuario_Baja, FEC_BAJA = :fec_Baja, NOM_USUARIO_BAJA=:nom_Usuario_Baja WHERE COD_TIPO_BIO = :cod_tipo_bio");
            $consulta->bindValue(':cod_tipo_bio', $this->cod_tipo_bio, PDO::PARAM_INT);
        }
            $consulta->bindValue(':des_tipo_bio', $this->des_tipo_bio, PDO::PARAM_STR);
            $consulta->bindValue(':fec_Alta', $this->fec_Alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $consulta->bindValue(':nom_Usuario_Alta', $this->nom_Usuario_Alta, PDO::PARAM_STR);
            if (!is_null($this->fec_Baja)) {
                $consulta->bindValue(':fec_Baja', $this->fec_Baja->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $consulta->bindValue(':nom_Usuario_Baja', $this->nom_Usuario_Baja, PDO::PARAM_STR);
            } else {
                $consulta->bindValue(':fec_Baja', null, PDO::PARAM_NULL);
                $consulta->bindValue(':nom_Usuario_Baja', null, PDO::PARAM_NULL);
            }
            $consulta->execute();
            $conexion = null;
            return true;
    }

    //Método para cargar en los atributos del objeto los datos de la bbdd a partir de su parámetro cod_tipo_bio
    public function cargar(int $cod_tipo_bio): bool {
        $conexion = new Conexion();
        $consulta = $conexion->conexion->prepare("SELECT * FROM ttbio WHERE COD_TIPO_BIO = :cod_tipo_bio");
        $consulta->bindParam(':cod_tipo_bio', $cod_tipo_bio, PDO::PARAM_INT);
        $consulta->execute();
        $resultado = $consulta->fetch();
        if ($resultado) {
            $this->cod_tipo_bio = $resultado['COD_TIPO_BIO'];
            $this->des_tipo_bio = $resultado['DES_TIPO_BIO'];
            $this->fec_Alta = new DateTime($resultado['FEC_ALTA']);
            $this->nom_Usuario_Alta = $resultado['NOM_USUARIO_ALTA'];
            if (!is_null($resultado['FEC_BAJA'])) {
                $this->fec_Baja = new DateTime($resultado['FEC_BAJA']);
                $this->nom_Usuario_Baja = $resultado['NOM_USUARIO_BAJA'];
            }
            $conexion = null;
            return true;
        }
        $conexion = null;
        return false;
    }

    

    
//<<<<<<<<<<<<<<<<<<<<< GETTERS Y SETTERS >>>>>>>>>>>>>>>>>>>>>>>>>>

    public function getCodTipoBio()
    {
        return $this->cod_tipo_bio;
    }

    public function setCodTipoBio($cod_tipo_bio)
    {
        $this->cod_tipo_bio = $cod_tipo_bio;

        return $this;
    }

    public function getDesTipoBio()
    {
        return $this->des_tipo_bio;
    }

    public function setDesTipoBio($des_tipo_bio)
    {
        $this->des_tipo_bio = $des_tipo_bio;

        return $this;
    }

    public function getFecAlta()
    {
        return $this->fec_Alta;
    }

    public function setFecAlta($fec_Alta)
    {
        $this->fec_Alta = $fec_Alta;

        return $this;
    }

    public function getNomUsuarioAlta()
    {
        return $this->nom_Usuario_Alta;
    }

    public function setNomUsuarioAlta($nom_Usuario_Alta)
    {
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;

        return $this;
    }

    public function getFecBaja()
    {
        return $this->fec_Baja;
    }

    public function setFecBaja($fec_Baja)
    {
        $this->fec_Baja = $fec_Baja;

        return $this;
    }

    public function getNomUsuarioBaja()
    {
        return $this->nom_Usuario_Baja;
    }

    public function setNomUsuarioBaja($nom_Usuario_Baja)
    {
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;

        return $this;
    }

}