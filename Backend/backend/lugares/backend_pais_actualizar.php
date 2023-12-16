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
    // $usuarioOper          = $_POST['idUsuarioOper'];
}

//POST TEST
// $platformType   = 'app';
// $countryID      = 2;


$countryID = $_POST['countryID'];
$resultObtenerInfoCountry = obtenerInfoCountry($dbConnect, 'countryID', $countryID);
// $nombreUsuario = $resultadoObtenerDatos['nombres'];
// $usuario = $resultadoObtenerDatos['usuario'];

if (!empty($resultObtenerInfoCountry)) {
    // $_POST['countryName'] = 'Estados Unidos';
    $countryName = existeCampoPost($_POST,'countryName',$resultObtenerInfoCountry['countryName']);

    $resultActualizarCountry = actualizarCountry($dbConnect, $countryName, $countryID);
    $arrayResultados = unirArrays($arrayResultados,$resultActualizarCountry);
}

// LOG DE MOVIMIENTOS
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuario." Actualizó el usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, null, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

if ($platformType == 'app') {
    $objetoRespuesta['country'] = $resultObtenerInfoCountry;
}

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "País actualizado";
} else {
    $codigo = "fallo";
    $mensaje = "";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
?>
