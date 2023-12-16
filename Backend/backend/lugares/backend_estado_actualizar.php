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
$platformType   = 'app';
$stateID      = 2;


// $stateID = $_POST['stateID'];
$resultObtenerInfoState = obtenerInfoState($dbConnect, 'stateID', $stateID);
// $nombreUsuario = $resultadoObtenerDatos['nombres'];
// $usuario = $resultadoObtenerDatos['usuario'];

if (!empty($resultObtenerInfoState)) {
    $_POST['stateName'] = 'Washington';
    $_POST['countryID'] = 2;

    $stateName = existeCampoPost($_POST,'stateName',$resultObtenerInfoState['stateName']);
    $countryID = existeCampoPost($_POST,'countryID',$resultObtenerInfoState['countryID']);

    $resultActualizarState = actualizarState($dbConnect, $stateName, $countryID, $stateID);
    $arrayResultados = unirArrays($arrayResultados,$resultActualizarState);
}

// LOG DE MOVIMIENTOS
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuario." Actualizó el usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, null, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

if ($platformType == 'app') {
    $objetoRespuesta['state'] = $resultObtenerInfoState;
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
