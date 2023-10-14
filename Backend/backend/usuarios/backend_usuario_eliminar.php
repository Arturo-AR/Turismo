<?php

require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_log_movimientos.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_global.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/usuarios/db_usuarios.php';

if (!isset($backendIncluido)){
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    $fechaOper = date('Y/m/d');
    $horaOper = date('H:s:i');
    $usuarioOper = $_POST['idUsuarioOper'];
}
$idUsuario = $_POST['idUsuario'];
$estatus = $_POST['estatus'];
$resultadoObtenerDatos = obtenerDatosUsuario($dbConnect,'idUsuario',$idUsuario);
$nombreUsuario = $resultadoObtenerDatos['nombres'];
$usuario = $resultadoObtenerDatos['usuario'];
// $estatus               = $resultadoObtenerDatos['eliminado'];

if ($estatus == 0) {
    $estatus = 1;
}else {
    $estatus = 0;
}
$resultadoEliminarUsuario = eliminarUsuario($dbConnect, $estatus, $idUsuario);
$arrayResultados = unirArrays($arrayResultados,$resultadoEliminarUsuario);
// LOG DE MOVIMIENTOS
$idEmpresa = NULL;
$area = "USUARIOS";
$detalleMovimiento = $nombreUsuario." Cambió estatus de usuario: ".$usuario;
$crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, $area, $detalleMovimiento);
$arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

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
