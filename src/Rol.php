<?php

namespace Clases;

class Rol {
    // Atributos    
    private int $cod_Rol;
    private string $nom_Rol;
    private string $descripcion;
    private DateTime $fec_Alta;
    private string $nom_Usuario_Alta;
    private ?DateTime $fec_Baja;
    private ?string $nom_Usuario_Baja;
    private Privilegio $privilegios;
// Constructor
    public function __construct(
        int $cod_Rol,
        string $nom_Rol,
        string $descripcion,
        DateTime $fec_Alta,
        string $nom_Usuario_Alta,
        ?DateTime $fec_Baja = null,
        ?string $nom_Usuario_Baja = null,
        Privilegio $privilegios
    ) {
        $this->cod_Rol = $cod_Rol;
        $this->nom_Rol = $nom_Rol;
        $this->descripcion = $descripcion;
        $this->fec_Alta = $fec_Alta;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
        $this->fec_Baja = $fec_Baja;
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
        $this->privilegios = $privilegios;
    }
//Asignar permisos a un rol
    public function asignarPermisos(Privilegio $privilegios): void {
        $this->privilegios = $privilegios;
    }

    // Getters
    public function obtenerPermisos(): Privilegio {
        return $this->privilegios;
    }

    public function obtenerRol(): string {
        return $this->nom_Rol;
    }

    public function obtenerDescripcion(): string {
        return $this->descripcion;
    }

    public function obtenerFechaAlta(): DateTime {
        return $this->fec_Alta;
    }

    public function obtenerUsuarioAlta(): string {
        return $this->nom_Usuario_Alta;
    }

    public function obtenerFechaBaja(): ?DateTime {
        return $this->fec_Baja;
    }

    public function obtenerUsuarioBaja(): ?string {
        return $this->nom_Usuario_Baja;
    }

    public function obtenerCodigoRol(): int {
        return $this->cod_Rol;
    }

// Destructor
    public function __destruct() {
        unset($this->cod_Rol);
        unset($this->nom_Rol);
        unset($this->descripcion);
        unset($this->fec_Alta);
        unset($this->nom_Usuario_Alta);
        unset($this->fec_Baja);
        unset($this->nom_Usuario_Baja);
        unset($this->privilegios);
    }
// Modificar Rol en una sola función
    public function modificarRol(
        string $nom_Rol,
        string $descripcion,
        DateTime $fec_Alta,
        string $nom_Usuario_Alta,
        ?DateTime $fec_Baja = null,
        ?string $nom_Usuario_Baja = null,
        Privilegio $privilegios
    ): void {
        $this->nom_Rol = $nom_Rol;
        $this->descripcion = $descripcion;
        $this->fec_Alta = $fec_Alta;
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
        $this->fec_Baja = $fec_Baja;
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
        $this->privilegios = $privilegios;
    }

    // Setters
    public function setNombreRol(string $nom_Rol): void {
        $this->nom_Rol = $nom_Rol;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setFechaAlta(DateTime $fec_Alta): void {
        $this->fec_Alta = $fec_Alta;
    }

    public function setUsuarioAlta(string $nom_Usuario_Alta): void {
        $this->nom_Usuario_Alta = $nom_Usuario_Alta;
    }

    public function setFechaBaja(?DateTime $fec_Baja): void {
        $this->fec_Baja = $fec_Baja;
    }

    public function setUsuarioBaja(?string $nom_Usuario_Baja): void {
        $this->nom_Usuario_Baja = $nom_Usuario_Baja;
    }

//Método para cargar rol de la bbdd a partir del código de rol
    public function cargarRol(int $cod_Rol): bool {
        // Crear la conexión
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        // Consulta
        $sql = "SELECT * FROM trol WHERE cod_Rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $cod_Rol);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result(
                $this->cod_Rol,
                $this->nom_Rol,
                $this->descripcion,
                $this->fec_Alta,
                $this->nom_Usuario_Alta,
                $this->fec_Baja,
                $this->nom_Usuario_Baja,
                unserialize($this->privilegios)
            );
            $stmt->fetch();
            $stmt->close();
            $conexion->cerrar();
            return true;
        } else {
            $stmt->close();
            $conexion->cerrar();
            return false;
        }
    }

    //Método para grabar el rol en la bbdd
    public function grabar(): bool {
        // Crear la conexión
        $conexion = new Conexion();
        // Consulta
        $sql = "INSERT INTO trol (NOM_ROL, DES_ROL, FEC_ALTA, NOM_USUARIO_ALTA, FEC_BAJA, NOM_USUARIO_BAJA, PRIVILEGIOS) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->conexion->prepare($sql);
        $stmt->bind_param(
            'sssssss',
            $this->nom_Rol,
            $this->descripcion,
            $this->fec_Alta->format('d-m-Y'),
            $this->nom_Usuario_Alta,
            $this->fec_Baja->format('d-m-Y'),
            $this->nom_Usuario_Baja,
            serialize($this->privilegios)
        );
        $stmt->execute();
        $stmt=null;
        return true;
    }

    //Método para cargar los roles de la bbdd
    public static function cargarRoles(): array {
        $roles = [];
        // Crear la conexión
        $conexion = new Conexion();
        // Consulta
        $sql = "SELECT * FROM trol";
        $stmt = $conexion->conexion->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result(
                $cod_Rol,
                $nom_Rol,
                $descripcion,
                $fec_Alta,
                $nom_Usuario_Alta,
                $fec_Baja,
                $nom_Usuario_Baja,
                $privilegios
            );
            while ($stmt->fetch()) {
                $roles[] = new Rol(
                    $cod_Rol,
                    $nom_Rol,
                    $descripcion,
                    $fec_Alta,
                    $nom_Usuario_Alta,
                    $fec_Baja,
                    $nom_Usuario_Baja,
                    unserialize($privilegios)
                );
            }
        }
        $stmt=null;
        return $roles;
    }


}