<?php
require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_log_movimientos.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");

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

// $userID = 1;
$userID = $_POST['userID'];
$resultGetUserInfo = GetUserInfo($dbConnect, 'userID', $userID);
// $nombreUsuario = $resultadoObtenerDatos['nombres'];
// $usuario = $resultadoObtenerDatos['usuario'];

if (!empty($resultGetUserInfo)) {
    // $_POST['userLastName']   = '';
    // $_POST['userPhoneNumber'] = '5548193429';
    // $_POST['userAge']        = 22;
    $userFirstName = existeCampoPost($_POST,'userFirstName',$resultGetUserInfo['userFirstName']);
    $userLastName = existeCampoPost($_POST,'userLastName',$resultGetUserInfo['userLastName']);
    $userEmail = existeCampoPost($_POST,'userEmail',$resultGetUserInfo['userEmail']);
    $userPassword = existeCampoPost($_POST,'userPassword',$resultGetUserInfo['userPassword']);
    $userPhoneNumber = existeCampoPost($_POST,'userPhoneNumber',$resultGetUserInfo['userPhoneNumber']);
    $userAge = existeCampoPost($_POST,'userAge',$resultGetUserInfo['userAge']);

    $resultUserUpdate = updateUserInfo($dbConnect, $userFirstName, $userLastName, $userEmail, $userPassword, $userPhoneNumber, $userAge, $userID);
    $arrayResultados = unirArrays($arrayResultados,$resultUserUpdate);
}

// LOG DE MOVIMIENTOS
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuario." Actualizó el usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, null, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Usuario actualizado";
} else {
    $codigo = "fallo";
    $mensaje = "";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
?>
