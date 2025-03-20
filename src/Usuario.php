<?php

namespace Clases;
use PDO;
use PDOEception;
use DateTime;

class Usuario{
    // Atributos
    private int $cod_usuario;
    private string $nom_login;
    private string $des_contrasena;
    private string $des_correo;
    private DateTime $fec_alta;
    private string $nom_usuario_alta;
    private ?DateTime $fec_baja;
    private ?string $nom_usuario_baja;
    private array $roles;  

    //Método constructor
    public function __construct() {
        $this->fec_Baja = null;
        $this->des_contrasena="";
        $this->nom_Usuario_Baja = null;
        $this->cod_usuario=0;
        $this->roles[]=null;
    }

    

    // Método para cargar datos de la bbdd
    public function cargarUsuario(int $cod_usuario): void {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM tusuario WHERE COD_USUARIO = :cod_Usuario";
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindParam(':cod_Usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $this->cod_usuario = $usuario['COD_USUARIO'];
                $this->nom_login = $usuario['NOM_LOGIN'];
                $this->des_contrasena = $usuario['DES_CONTRASENA'];
                $this->des_correo = $usuario['DES_CORREO'];
                $this->fec_alta = new DateTime($usuario['FEC_ALTA']);
                $this->nom_usuario_alta = $usuario['NOM_USUARIO_ALTA'];
                $this->fec_baja = $usuario['FEC_BAJA'] ? new DateTime($usuario['FEC_BAJA']) : null;
                $this->nom_usuario_baja = $usuario['NOM_USUARIO_BAJA'];
            }
        } catch (PDOException $e) {
            echo "Error al cargar el usuario: " . $e->getMessage();
        }
    }

    //Método que compara contraseñas
    public function compararContrasena(string $contrasena, string $hash): bool {
        return password_verify($contrasena, $hash);
    }

    //Método para obtender roles
    private function cargarRol(){
        try {
            $conexion = new Conexion();
            $rol = new Rol();
            $consulta = "SELECT * FROM tusuariorol WHERE COD_USUARIO = :cod_usuario";
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindValue('cod_usuario',$this->cod_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($resultado){
                $contador=0;
                foreach ($resultado as $r){
                    $codRol = $r['COD_ROL'];
                    $rol->cargarRol($codRol);
                    $arrayRoles[$contador]=$rol->getRol();
                }
                $this->roles = $arrayRoles;
            } return;
        }catch(PDOException $e){
            echo "Error al cargar los roles: ".$e;
            return;
        }
    }
    
    //Método para iniciar sesión
    public function iniciarSesion(string $nom_login, string $contrasena): bool {
        try {
            $conexion = new Conexion();
            // Preparo la consulta
            $consulta = "SELECT * FROM tusuario WHERE NOM_LOGIN = :nom_login";
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindParam(':nom_login', $nom_login, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && $this->compararContrasena($contrasena, $usuario['DES_CONTRASENA'])) {
                // Iniciar sesión
                $this->cod_usuario = $usuario['COD_USUARIO'];
                $this->cargarRol();
                $_SESSION['COD_USUARIO'] = $usuario['COD_USUARIO'];
                $_SESSION['NOM_USUARIO'] = $usuario['NOM_LOGIN'];
                $_SESSION['ROLES'] = $this->roles;
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
            return false;
        }
    }

    //Método para crear usuario
    public function grabar() {
        try {
            $conexion = new Conexion();
            if ($this->cod_usuario==0 || is_null($this->cod_usuario)){
                $consulta = "INSERT INTO tusuario (NOM_LOGIN, DES_CONTRASENA, DES_CORREO, FEC_ALTA, NOM_USUARIO_ALTA) VALUES (:nom_Login, :des_Contrasena, :des_Correo, :fec_Alta, :nom_Usuario_Alta)";
                $stmt = $conexion->conexion->prepare($consulta);
            }else{
                $consulta = "UPDATE tusuario SET NOM_LOGIN = :nom_Login, DES_CONTRASENA = :des_Contrasena, DES_CORREO = :des_Correo,
                 FEC_ALTA = :fec_Alta, NOM_USUARIO_ALTA = :nom_Usuario_Alta WHERE COD_USUARIO = :cod_Usuario";
                 $stmt = $conexion->conexion->prepare($consulta);
                 $stmt->bindValue('cod_Usuario', $this->cod_usuario, PDO::PARAM_INT);
            }
            $stmt->bindValue('nom_Login', $this->nom_login, PDO::PARAM_STR);
            $stmt->bindValue('des_Contrasena', $this->des_contrasena, PDO::PARAM_STR); // Guardar la contraseña hasheada
            $stmt->bindValue('des_Correo', $this->des_correo, PDO::PARAM_STR);
            $stmt->bindValue('fec_Alta', $this->fec_alta->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue('nom_Usuario_Alta', $this->nom_usuario_alta, PDO::PARAM_STR);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo "Error al crear el usuario: " . $e->getMessage();
            return;
        }
    }

    //Método para modificar usuario con parámetros nombre y password
    public function modificarUsuario(string $nombre, string $password): bool {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $conexion = new Conexion();
            $consulta = "UPDATE tusuario SET NOM_LOGIN = :NOM_LOGIN, DES_CONTRASENA = :des_contrasena WHERE COD_USUARIO = :cod_Usuario";
            $stmt = $conexion->conexion->prepare($consulta);
            $stmt->bindParam(':NOM_LOGIN', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':DES_CONTRASENA', $hashedPassword, PDO::PARAM_STR);
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
            $stmt = $conexion->conexion->prepare($consulta);
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
//<<<<<<<<<<<<<<<<<<<<<<<<<< GETTERS Y SETTERS >>>>>>>>>>>>>>>>>>>>>>>>>>
// Getters
public function getCodUsuario(): int {
    return $this->cod_usuario;
}

public function getNomLogin(): string {
    return $this->nom_login;
}

public function getDesContrasena(): string {
    return $this->des_contrasena;
}

public function getDesCorreo(): string {
    return $this->des_correo;
}

public function getFecAlta(): DateTime {
    return $this->fec_alta;
}

public function getNomUsuarioAlta(): string {
    return $this->nom_usuario_alta;
}

public function getFecBaja(): ?DateTime {
    return $this->fec_baja;
}

public function getNomUsuarioBaja(): ?string {
    return $this->nom_usuario_baja;
}

// Setters
public function setCodUsuario(int $cod_usuario): void {
    $this->cod_usuario = $cod_usuario;
}

public function setNomLogin(string $nom_login): void {
    $this->nom_login = $nom_login;
}

public function setDesContrasena(string $des_contrasena): void {
    $hashedPassword = password_hash($des_contrasena, PASSWORD_DEFAULT);
    $this->des_contrasena = $hashedPassword;
}

public function setDesCorreo(string $des_correo): void {
    $this->des_correo = $des_correo;
}

public function setFecAlta(DateTime $fec_alta): void {
    $this->fec_alta = $fec_alta;
}

public function setNomUsuarioAlta(string $nom_usuario_alta): void {
    $this->nom_usuario_alta = $nom_usuario_alta;
}

public function setFecBaja(?DateTime $fec_baja): void {
    $this->fec_baja = $fec_baja;
}

public function setNomUsuarioBaja(?string $nom_usuario_baja): void {
    $this->nom_usuario_baja = $nom_usuario_baja;
}
}