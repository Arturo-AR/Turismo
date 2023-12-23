<?php
require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_logmove.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/lugares/db_lugares.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");

if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    $operDate = date('Y/m/d');
    $operTime = date('H:s:i');
    $userID = $_POST['userID'];
    // $userID = 1;
}

//POST TEST
// $townID = 2;


$townID = $_POST['townID'];
$resultObtenerInfoTown = obtenerInfoTown($dbConnect, 'townID', $townID);
$townNameOld = $resultObtenerInfoTown[0]['townName'];

if (!empty($resultObtenerInfoTown)) {
    // $_POST['townName'] = 'Seattle';
    // $_POST['stateID'] = 2;

    $townName = existeCampoPost($_POST,'townName',$resultObtenerInfoTown[0]['townName']);
    $stateID = existeCampoPost($_POST,'stateID',$resultObtenerInfoTown[0]['stateID']);

    $resultActualizarTown = actualizarTown($dbConnect, $townName, $stateID, $townID);
    $arrayResultados = unirArrays($arrayResultados,$resultActualizarTown);
}

// LOG DE MOVIMIENTOS
$reultadoGetUserInfo = GetUserInfo($dbConnect, 'userID', $userID);
$userFirstName = $reultadoGetUserInfo['userFirstName'];
$area = "Town";
$movDetail = $userFirstName." Con ID: ".$userID." Actualizó información de town ".$townID;
$crearLogMove = crearLogMove($dbConnect, $operDate, $operTime, $userID, $area, $movDetail);
$arrayResultados = unirArrays($arrayResultados, $crearLogMove);

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Ciudad actualizada";
} else {
    $codigo = "fallo";
    $mensaje = "";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
?>
