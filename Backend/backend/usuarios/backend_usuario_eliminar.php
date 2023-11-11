<?php

require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_log_movimientos.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");

if (!isset($backendIncluido)){
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
// $userID     = 1;
// $eliminado  = 1;

$userID = $_POST['userID'];
$eliminado = $_POST['eliminado'];

$resultGetUserInfo = GetUserInfo($dbConnect,'userID',$userID);
$nombreUsuario = $resultGetUserInfo['userFirstName'];
// $usuario = $resultGetUserInfo['usuario'];
// $estatus               = $resultGetUserInfo['eliminado'];

if ($eliminado == 0) {
    $eliminado = 1;
}else {
    $eliminado = 0;
}
$resultUserDelete = userDelete($dbConnect, $eliminado, $userID);
$arrayResultados = unirArrays($arrayResultados,$resultUserDelete);
// LOG DE MOVIMIENTOS
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuario." Cambió estatus de usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

if (!isset($backendIncluido)){
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Cambio estatus de usuario";
}else {
    $codigo = "fallo";
    $mensaje = "";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
