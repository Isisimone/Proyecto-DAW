<?php

namespace Clases;

class Usuario{
    // Atributos
    private int $cod_Usuario;
    private string $nom_Login;
    private string $des_contrasena;
    private string $des_Correo;
    private date $fec_Alta;
    private string $nom_Usuario_Alta;
    private ?date $fec_Baja;
    private ?string $nom_Usuario_Baja;

    //Método constructor
    public function __construct(
        int $cod_Usuario,
        string $nom_Login,
        string $des_contrasena,
        string $des_Correo,
        date $fec_Alta,
        string $nom_Usuario_Alta,
        ?date $fec_Baja = null,
        ?string $nom_Usuario_Baja = null
    ) {
        $this->cod_Usuario = $cod_Usuario;
        $this->nom_Login = $nom_Login;
        $this->des_contrasena = $des_contrasena;
        $this->des_Correo = $des_Correo;
        $this->fec_Alta = $fec_Alta;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
        $this->fec_Baja = $fec_Baja;
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
    }

    // Getters
    public function getCodUsuario(): int {
        return $this->cod_Usuario;
    }

    public function getNomLogin(): string {
        return $this->nom_Login;
    }

    public function getDesContraseña(): string {
        return $this->des_contrasena;
    }

    public function getDesCorreo(): string {
        return $this->des_Correo;
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
    public function setCodUsuario(int $cod_Usuario): void {
        $this->cod_Usuario = $cod_Usuario;
    }

    public function setNomLogin(string $nom_Login): void {
        $this->nom_Login = $nom_Login;
    }

    public function setDesContraseña(string $des_contrasena): void {
        $this->des_contrasena = $des_contrasena;
    }

    public function setDesCorreo(string $des_Correo): void {
        $this->des_Correo = $des_Correo;
    }

    public function setFecAlta(date $fec_Alta): void {
        $this->fec_Alta = $fec_Alta;
    }

    public function setNomUsuarioAlta(string $nom_Usuario_Alta): void {
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

    public function setFecBaja(?date $fec_Baja): void {
        $this->fec_Baja = $fec_Baja;
    }

    public function setNomUsuarioBaja(?string $nom_Usuario_Baja): void {
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
    }

    // Método para cargar datos de la bbdd
    public function cargarUsuario(int $cod_Usuario): void {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM tusuario WHERE cod_Usuario = :cod_Usuario";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':cod_Usuario', $cod_Usuario, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $this->cod_Usuario = $usuario['cod_Usuario'];
                $this->nom_Login = $usuario['nom_Login'];
                $this->des_contrasena = $usuario['des_contrasena'];
                $this->des_Correo = $usuario['des_Correo'];
                $this->fec_Alta = new DateTime($usuario['fec_Alta']);
                $this->nom_Usuario_Alta = $usuario['nom_Usuario_Alta'];
                $this->fec_Baja = $usuario['fec_Baja'] ? new DateTime($usuario['fec_Baja']) : null;
                $this->nom_Usuario_Baja = $usuario['nom_Usuario_Baja'];
            }
        } catch (PDOException $e) {
            echo "Error al cargar el usuario: " . $e->getMessage();
        }
    }

    //Método que compara contraseñas
    public function compararContraseña(string $contraseña): bool {
        return password_verify($contraseña, $this->des_contrasena);
    }

    //Método para crear usuario
    public function crearUsuario(int $empleado): bool {
        try {
            $conexion = new Conexion();
            $consulta = "INSERT INTO tusuario (NOM_LOGIN, DES_CONTRASENA, DES_CORREO, FEC_ALTA, NOM_USUARIO_ALTA) VALUES (:nom_Login, :des_contrasena, :des_Correo, :fec_Alta, :nom_Usuario_Alta)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':NOM_LOGIN', $this->nom_Login, PDO::PARAM_STR);
            $stmt->bindParam(':DES_CONTRASENA', $this->des_contrasena, PDO::PARAM_STR);
            $stmt->bindParam(':DES_CORREO', $this->des_Correo, PDO::PARAM_STR);
            $stmt->bindParam(':FEC_ALTA', $this->fec_Alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':NOM_USUARIO_ALTA', $this->nom_Usuario_Alta, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al crear el usuario: " . $e->getMessage();
            return false;
        }
    }

    //Método para modificar usuario con parámetros nombre y password
    public function modificarUsuario(string $nombre, string $password): bool {
        try {
            $conexion = new Conexion();
            $consulta = "UPDATE tusuario SET NOM_LOGIN = :NOM_LOGIN, DES_CONTRASENA = :des_contrasena WHERE COD_USUARIO = :cod_Usuario";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':NOM_LOGIN', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':DES_CONTRASENA', $password, PDO::PARAM_STR);
            $stmt->bindParam(':COD_USUARIO', $this->cod_Usuario, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al modificar el usuario: " . $e->getMessage();
            return false;
        }
    }

    //Método para dar de baja a un usuario
    public function darBajaUsuario(int $empleado): bool {
        try {
            $conexion = new Conexion();
            $consulta = "UPDATE tusuario SET FEC_BAJA = :fec_Baja, NOM_USUARIO_BAJA = :nom_Usuario_Baja WHERE COD_USUARIO = :cod_Usuario";
            $stmt = $conexion->prepare($consulta);
            $fec_Baja = new DateTime();
            $stmt->bindParam(':FEC_BAJA', $fec_Baja->format('d-m-Y H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':NOM_USUARIO_BAJA', $nom_Usuario_Baja, PDO::PARAM_STR);
            $stmt->bindParam(':COD_USUARIO', $this->cod_Usuario, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al dar de baja el usuario: " . $e->getMessage();
            return false;
        }
    }
}