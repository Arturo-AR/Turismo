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
// $countryName        = 'México';

// $fechaAlta = date('Y/m/d');
$countryName      = $_POST['countryName'];


$resultadoRegistrarCountry = registrarCountry($dbConnect,$countryName);
$arrayResultados = unirArrays($arrayResultados,$resultadoRegistrarCountry);
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
    $mensaje = "País creado";
}else {
    $codigo = "fallo";
    $mensaje = "País no creado";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
