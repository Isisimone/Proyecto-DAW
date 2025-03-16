<?php

require '../vendor/autoload.php';

use Clases\Conexion;
use Clases\Ajuste;
use Clases\DatosBiometricos;
use Clases\Empleado;
use Clases\Marcaje;
use Clases\Privilejio;
use Clases\Rol;
use Clases\TipoDatoBiometrico;
use Clases\Transaccion;
use Clases\Usuario;

$ajuste = new Ajuste();
$datosBiometricos = new DatosBiometricos();
$empleado = new Empleado();
//$marcaje = new Marcaje();
//$privilejio = new Privilejio();
//$rol = new Rol();
//$tipoDatoBiometrico = new TipoDatoBiometrico();
//$transaccion = new Transaccion();
//$usuario = new Usuario();

//Prueba de ajustes
$ajustes = $ajuste->obtenerAjustes();
var_dump($ajustes);
$ajustes = $ajuste->obtenerAjuste(1);
var_dump($ajustes);
$ajuste->actualizarAjuste(1, 'umbral', '0.8');
$ajustes = $ajuste->obtenerAjuste(1);
var_dump($ajustes);

//Prueba de Datos Biometricos
$datosBiometricos->setCodBio(2);
$datosBiometricos->setCodEmpleado(1);
$datosBiometricos->setCodTipo(1);
$datosBiometricos->setDatoBio('dadsdsdsdsds');
$fecha = new DateTime();
$datosBiometricos->setFecAlta($fecha);
$datosBiometricos->setNomUsuarioAlta('admin');
$datosBiometricos->grabar();
$datosBiometricos = $datosBiometricos->cargar(6);
var_dump($datosBiometricos);
//$datosBiometricos->eliminar(); 

//Prueba de Empleado
$empleado->cargarDatosEmpleado(1);
var_dump($empleado);
$empleado2 = new Empleado();
$empleado2->setCodEmpleado(2);
$empleado2->setCodUsuario(2);
$empleado2->setNombre('Juan');
$empleado2->setApellido1('Perez');
$empleado2->setApellido2('Gomez');
$empleado2->setContacto('juanpg@local.com');
$empleado2->setFecAlta($fecha);
$empleado2->setNomUsuarioAlta('admon');
echo $empleado2->getFecBaja();
$empleado2->grabar($empleado2);
$empleado2->cargarDatosEmpleado(2);
var_dump($empleado2);
$empleado2->darBaja('admon',$fecha);
$empleado2->cargarDatosEmpleado(2);
var_dump($empleado2);
$empleado2->setApellido1('Sánchez');
$empleado2->modificar();
$empleado2->cargarDatosEmpleado(2);
var_dump($empleado2);
