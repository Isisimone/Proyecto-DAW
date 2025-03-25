<?php

namespace Clases;
//Clases a usar
use DateTime;
use DateTimeZone;
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
        $this->cod_Marcaje = 0;        
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

    //Método para convertir fechas de UTC a Europe/Madrid
    private function convertirFecha(string $fechaUTC): string {
        $fecha = new DateTime($fechaUTC, new DateTimeZone('UTC'));
        $fecha->setTimezone(new DateTimeZone('Europe/Madrid'));
        return $fecha->format('Y-m-d H:i:s');
    }

    //Método para obtener el TIPO del último marcaje 
    public function ultimoMarcaje($empleado){
        try{
            //Crea una conexión y una consulta SELECT
            $conexion = new Conexion();
            $consulta = $conexion->conexion->prepare("SELECT COD_TIPO_MARCAJE FROM tmarcaje WHERE COD_EMPLEADO = :cod ORDER BY FEC_MARCAJE DESC LIMIT 1");
            //Parametriza y ejecuta
            $consulta->bindValue(':cod', $empleado, PDO::PARAM_INT);
            $consulta->execute();
            //Vuelca el resultado
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            //Devuelve el tipo de marcaje para saber si entra (1) o sale (2)
            return $resultado['COD_TIPO_MARCAJE'];
        }catch(PDOException $e){
            //Muestra error y devuelve false
            error_log("Error al obtener marcaje: " . $e->getMessage());
            return false;
        }
    }

    //Método que devuelve las horas trabajadas en la fecha indicada
    public function calcularHorasTrabajadas(int $codEmpleado, DateTime $fecha): float {
        try {
            // Obtiene los marcajes del día
            $marcajesDelDia = $this->marcajesHoy($codEmpleado, $fecha);
    
            // Inicializa las variables para el cálculo
            $horasTrabajadas = 0;
            $ultimoMarcaje = null;
    
            foreach ($marcajesDelDia as $marcaje) {
                //Obtiene el tipo y fecha del marcaje(para la hora)
                $tipoMarcaje = $marcaje['COD_TIPO_MARCAJE'];
                $fechaMarcaje = new DateTime($marcaje['FEC_MARCAJE']);
    
                if ($tipoMarcaje == 1) {
                    // Si es un marcaje de entrada, guarda el marcaje para restarlo luego
                    $ultimoMarcaje = $fechaMarcaje;
                } elseif ($tipoMarcaje == 2 && $ultimoMarcaje !== null) {
                    // Si es un marcaje de salida, calcula la diferencia con el último marcaje de entrada
                    $intervalo = $ultimoMarcaje->diff($fechaMarcaje);
                    $horasTrabajadas += $intervalo->h + ($intervalo->i / 60); // Convierte minutos a horas
                    $ultimoMarcaje = null; // Resetea el último marcaje
                }
            }
    
            // Si el último marcaje es de tipo entrada, ya fuera del bucle, calcula el tiempo hasta ahora
            //OJO, si se piden las horas de un marcaje incompleto sacará un número enorme de horas.
            if ($ultimoMarcaje !== null) {
                $intervalo = $ultimoMarcaje->diff(new DateTime());
                $horasTrabajadas += $intervalo->h + ($intervalo->i / 60); // Convierte minutos a horas
            }
            //Devielve las horas trabajadas(se debería de limitar con parámetro)
            //<<<<<<<<<<<<<<<<    PARAMETRO >>>>>>>>>>>>>>>>
            return $horasTrabajadas;
        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error al calcular las horas trabajadas: " . $e->getMessage());
            return 0;
        }
    }

    //Método para obtener marcajes del día
    public function marcajesHoy($empleado, DateTime $fecha){
        try{
            //Crea una conexión y una consulta SELECT
            $conexion = new Conexion();
            //consulta ascendente de los marcaje de fecha(No tiene en cuenta hora)
            $consulta = $conexion->conexion->prepare("SELECT COD_TIPO_MARCAJE, FEC_MARCAJE FROM tmarcaje WHERE COD_EMPLEADO = :cod AND DATE(FEC_MARCAJE) = :fec ORDER BY FEC_MARCAJE ASC");
            //Parametriza y ejecuta
            $consulta->bindValue(':cod', $empleado, PDO::PARAM_INT);
            $consulta->bindValue(':fec', $fecha->format('Y-m-d'));
            $consulta->execute();
            //Vuelca el resultado
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            // Convierte las fechas de UTC a Europe/Madrid
            foreach ($resultado as &$marcaje) {
                $marcaje['FEC_MARCAJE'] = $this->convertirFecha($marcaje['FEC_MARCAJE']);
            }
            //Devuelve array con el tipo y la fecha de cada marcaje
            return $resultado;
        }catch(PDOException $e){
            //Muestra error y devuelve false
            error_log("Error al obtener marcaje: " . $e->getMessage());
            return false;
        }
    }

    //Método para marcar de una sola vez, rellena todos los parámetros
    public function marcar($tipo,$empleado,$cod_bio,$fec_Mar,$fec_Grab,$incidencia,$pendiente,$foto,$tipo_acceso,$obs){
        $this->setCodTipoMarcaje($tipo);
        $this->setCodEmpleado($empleado);
        $this->setCodBio($cod_bio);
        $this->setFecMarcaje(new DateTime($fec_Mar));
        $this->setFecGrabacion(new DateTime($fec_Grab));
        $this->setIncidencia($incidencia);
        $this->setPendiente($pendiente);
        $this->setFoto($foto);
        $this->setTipoAcceso($tipo_acceso);
        $this->setObs($obs);
        $this->grabar();
    }

    //Método para registrar el marcaje en la bbdd
    public function grabar(): bool {
        try{
            $conexion = new Conexion();
            //Si no hay cod_Marcaje prepara un INSERT
            if ($this->cod_Marcaje==0 || is_null($this->cod_Marcaje)){
                $sql = "INSERT INTO tmarcaje (COD_TIPO_MARCAJE, COD_EMPLEADO, COD_BIO, DES_FOTO, FEC_MARCAJE, FEC_GRABACION, IND_INCIDENCIA, IND_PENDIENTE, COD_TIPO_ACCESO, DES_OBSERVACIONES) 
                VALUES (:COD_TIPO_MARCAJE, :COD_EMPLEADO, :COD_BIO, :DES_FOTO, :FEC_MARCAJE, :FEC_GRABACION, :IND_INCIDENCIA, :IND_PENDIENTE, :COD_TIPO_ACCESO, :DES_OBSERVACIONES)";
                $stmt = $conexion->conexion->prepare($sql);
            //Si hay cod_Marcaje prepara un UPDATE
            }else{
                $sql ="UPDATE tmarcaje SET COD_TIPO_MARCAJE = :COD_TIPO_MARCAJE, COD_EMPLEADO = :COD_EMPLEADO
                , COD_BIO = :COD_BIO, DES_FOTO=:DES_FOTO, FEC_MARCAJE=:FEC_MARCAJE
                , FEC_GRABACION=:FEC_GRABACION, IND_INCIDENCIA=:IND_INCIDENCIA, IND_PENDIENTE=:IND_PENDIENTE
                , COD_TIPO_ACCESO= :COD_TIPO_ACCESO, DES_OBSERVACIONES =:DES_OBSERVACIONES 
                WHERE COD_MARCAJE=:cod_Marcaje";
                $stmt = $conexion->conexion->prepare($sql);
                $stmt->bindValue(':cod_Marcaje', $this->cod_Marcaje);
            }
            //Parametriza la consulta
            $stmt->bindValue(':COD_TIPO_MARCAJE', $this->cod_Tipo_Marcaje);
            $stmt->bindValue(':COD_EMPLEADO', $this->cod_Empleado);
            $stmt->bindValue(':COD_BIO', $this->cod_bio);
            $stmt->bindValue(':DES_FOTO', $this->foto);
            $stmt->bindValue(':FEC_MARCAJE', $this->fec_Marcaje->format('Y-m-d H:i:s'));
            $stmt->bindValue(':FEC_GRABACION', $this->fec_Grabacion->format('Y-m-d H:i:s'));
            $stmt->bindValue(':IND_INCIDENCIA',$this->incidencia);
            $stmt->bindValue(':IND_PENDIENTE', $this->pendiente);
            $stmt->bindValue(':COD_TIPO_ACCESO', $this->tipoAcceso);
            $stmt->bindValue(':DES_OBSERVACIONES', $this->obs);
            //Ejecuta la consulta
            $stmt->execute();
            //Elimina el objeto conexión
            $conexion = null;
            //Devuelve true
            return true;
        }catch(PDOException $e){
            //Muestra error y devuelve false
            error_log("Error al grabar marcaje: " . $e->getMessage());
            return false;
        }
    }

    //Método para cargar los datos de un marcaje, devuelve objeto Marcaje
    public function cargar(int $cod_Marcaje): Marcaje {
        try{
            //Crea la conexión y prepara la consulta SELECT
            $conexion = new Conexion();
            $consulta = $conexion->conexion->prepare("SELECT * FROM tmarcaje WHERE COD_MARCAJE = :cod_Marcaje");
            //Parmetriza y ejecuta
            $consulta->bindParam(':cod_Marcaje', $cod_Marcaje);
            $consulta->execute();
            //Vuelca el resultado
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if (!$resultado) {
                //si no hay resultado devuelve false
                return $resultado;
            }
            //volcamos el resultado en los parámetros
            $this->cod_Marcaje = $resultado['COD_MARCAJE'];
            $this->cod_Tipo_Marcaje = $resultado['COD_TIPO_MARCAJE'];
            $this->cod_Empleado = $resultado['COD_EMPLEADO'];
            $this->cod_bio = $resultado['COD_BIO'];
            $this->fec_Marcaje = new DateTime($this->convertirFecha($resultado['FEC_MARCAJE']));
            $this->fec_Grabacion = new DateTime($this->convertirFecha($resultado['FEC_GRABACION']));
            $this->incidencia = $resultado['IND_INCIDENCIA'];
            $this->pendiente = $resultado['IND_PENDIENTE'];
            $this->foto = $resultado['DES_FOTO'];
            $this->tipoAcceso = $resultado['COD_TIPO_ACCESO'];
            $this->obs = $resultado['DES_OBSERVACIONES'];
            //devuelve el objeto mismo
            return $this;
        }catch(PDOException $e){
            //Muestra error y devuelve false
            error_log("Error al cargar marcaje: " . $e->getMessage());
            return false;
        }
    }

        //Método para cargar conjunto de marcajes entre fechas, devuelve array de registros
        public function cargarMarcajesEntreFechas(int $empleadoI, int $empleadoF, DateTime $fechaInicio, DateTime $fechaFin): array {
            try{
                //Crea conexión de tipo SELECT
                $conexion = new Conexion();
                $consulta = $conexion->conexion->prepare("
                    SELECT * FROM tmarcaje 
                    WHERE FEC_MARCAJE BETWEEN :fechaInicio AND :fechaFin 
                    AND COD_EMPLEADO BETWEEN :empleadoI AND :empleadoF
                ");
                //Parametriza y ejecuta
                $consulta->bindValue(':empleadoI', $empleadoI);
                $consulta->bindValue(':empleadoF', $empleadoF);
                $consulta->bindValue(':fechaInicio', $fechaInicio->format('Y-m-d H:i:s'));
                $consulta->bindValue(':fechaFin', $fechaFin->format('Y-m-d H:i:s'));
                $consulta->execute();
                //Vuelca el resultado
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                // Convierte las fechas de UTC a Europe/Madrid
                foreach ($resultado as &$marcaje) {
                    $marcaje['FEC_MARCAJE'] = $this->convertirFecha($marcaje['FEC_MARCAJE']);
                    $marcaje['FEC_GRABACION'] = $this->convertirFecha($marcaje['FEC_GRABACION']);
                }
                //Devuelve el resultado
                return $resultado;
            }catch(PDOException $e){
                //Muestra error y devuelve false
                error_log("Error al cargar marcajes: " . $e->getMessage());
                return false;
            }
            
        }
    
        //Obtener los últimos marcajes en un array descendente
        public function obtenerUltimosMarcajes(int $codEmpleado, int $limite = 5): array {
            try {
                // Crea la conexión y prepara la consulta SELECT
                $conexion = new Conexion();
                $consulta = $conexion->conexion->prepare("SELECT COD_TIPO_MARCAJE, FEC_MARCAJE, DES_FOTO 
                    FROM tmarcaje 
                    WHERE COD_EMPLEADO = :codEmpleado 
                    ORDER BY FEC_MARCAJE DESC 
                    LIMIT :limite
                ");
                // Parametriza y ejecuta
                $consulta->bindValue(':codEmpleado', $codEmpleado, PDO::PARAM_INT);
                $consulta->bindValue(':limite', $limite, PDO::PARAM_INT);
                $consulta->execute();
                // Vuelca el resultado
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                // Convierte las fechas de UTC a Europe/Madrid
                foreach ($resultado as &$marcaje) {
                    $marcaje['FEC_MARCAJE'] = $this->convertirFecha($marcaje['FEC_MARCAJE']);
                }
                //Devuelve el resultado
                return $resultado;
            } catch (PDOException $e) {
                // Muestra error y devuelve un array vacío
                error_log("Error al obtener los últimos marcajes: " . $e->getMessage());
                return [];
            }
        }
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<   GETTERS Y SETTERS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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

    public function getIncidencia(): int {
        return $this->incidencia;
    }

    public function getPendiente(): int {
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

    public function setIncidencia(int $incidencia): void {
        $this->incidencia = $incidencia;
    }

    public function setPendiente(int $pendiente): void {
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

}