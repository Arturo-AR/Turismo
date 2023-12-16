<?php

require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_log_movimientos.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/lugares/db_lugares.php");

if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    // $fechaOper = date('Y/m/d');
    // $horaOper = date('H:s:i');
    // $usuarioOper = $_POST['idUsuarioOper'];
}

//POST TEST
// $platformType       = 'app';
// $placeName          = 'Fuente De Las Tarascas';
// $placeDescription   = 'Esta fuente resultó ser un peculiar regalo, en el año de 1937, 
//                         para el General Lázaro Cárdenas del Rio, ya que se sabía era gran admirador de la belleza indígena, 
//                         tal presente fue colocado frente a su casa, que ahora es el edificio que ocupan las instalaciones del IMJU 
//                         (Instituto Michoacano de la Juventud), la mayor parte de los ciudadanos se maravilló ante tal monumento, 
//                         sin embargo, incomodó a varias personas, por mostrar el torso desnudo, 
//                         pero con el paso del tiempo se fueron acostumbrado a la belleza de esta fuente.';
// $placeImage         = 'URL//LasTarascas.png';
// $townID             = 1;

// $fechaAlta = date('Y/m/d');
$placeName           = $_POST['placeName'];
$placeDescription    = $_POST['placeDescription'];
$placeImage          = $_POST['placeImage'];
$townID              = $_POST['townID'];


$resultadoRegistrarPlace = registrarPlace($dbConnect, $placeName, $placeDescription, $placeImage, $townID);
$arrayResultados = unirArrays($arrayResultados,$resultadoRegistrarPlace);
// $idUsuarioCreado = $resultadoRegistrarUsuario[1];

// LOG DE MOVIMIENTOS
// $resultadoObtenerDatosUsuario = obtenerDatosUsuario($dbConnect, 'idUsuario', $usuarioOper);
// $nombreUsuarioLogueado = $resultadoObtenerDatosUsuario['nombres'];
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuarioLogueado." Registro un usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuarioCreado, $usuarioOper, $idEmpresa, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);
if ($platformType == 'app') {
    $objetoRespuesta['registro'] = true;
}

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Lugar de interés creado";
}else {
    $codigo = "fallo";
    $mensaje = "Lugar de interés no creado";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
