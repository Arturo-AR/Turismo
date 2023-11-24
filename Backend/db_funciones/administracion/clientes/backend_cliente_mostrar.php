<?php

require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/actividades/db_log_movimientos.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_global.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/clientes/db_clientes.php';

$dbConnect = comenzarConexion();
$codigo = 'exito';
$mensaje = '';
$objetoRespuesta = array();

$resultadoMostrarClientes = mostrarClientes($dbConnect);

cerrarConexion($dbConnect);

if (!empty($resultadoMostrarClientes)) {
    $objetoRespuesta['cliente']    = $resultadoMostrarClientes;
}else {
    $codigo          = 'fallo';
    $mensaje         = "No hay clientes";
    $objetoRespuesta = "";
}


echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);

?>
