<?php
require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/lugares/db_lugares.php");

if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = 'exito';
    $mensaje = '';
    $fechaOper = date('Y/m/d');
    $horaOper = date('H:s:i');
}

// $platformType = 'app';
if ($platformType == 'web' OR $platformType == 'app') {
    // $countryID = 1;
    $countryID = $_POST['countryID'];
    $resultadoObtenerInfoState = obtenerInfoState($dbConnect, 'countryID', $countryID);
    if (!empty($resultadoObtenerInfoState)) {
        $objetoRespuesta['datos'] = $resultadoObtenerInfoState;
    } else {
        $codigo = "fallo";
        $mensaje = "No se encontrarón estados";
        $objetoRespuesta = "";
    }
}else{
    $codigo = "fallo";
    $mensaje = "";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);

if (!isset($backendIncluido))
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
