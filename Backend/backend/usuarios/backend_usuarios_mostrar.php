<?php
require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");

if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    $fechaOper = date('Y/m/d');
    $horaOper = date('H:s:i');
}

// $userID = 1;
$userID = $_POST['userID'];
$resultShowUser = GetUserInfo($dbConnect, 'userID', $userID);
if (!empty($resultShowUser)) {
    $objetoRespuesta['datos']['userFirstName'] = $resultShowUser['userFirstName'];
    $objetoRespuesta['datos']['userLastName'] = $resultShowUser['userLastName'];
    $objetoRespuesta['datos']['userEmail'] = $resultShowUser['userEmail'];
    $objetoRespuesta['datos']['userPassword'] = $resultShowUser['userPassword'];
    $objetoRespuesta['datos']['userPhoneNumber'] = $resultShowUser['userPhoneNumber'];
    $objetoRespuesta['datos']['userAge'] = $resultShowUser['userAge'];
} else {
    $mensaje = "No hay datos de usuario";
    $objetoRespuesta = "";
}

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);

if (!isset($backendIncluido))
    echo json_encode($respuesta, JSON_ERROR_UTF8);


?>
