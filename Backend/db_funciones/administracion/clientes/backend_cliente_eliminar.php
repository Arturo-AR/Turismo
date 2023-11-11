<?php

require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/actividades/db_log_movimientos.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_global.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/usuarios/db_usuarios.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/clientes/db_clientes.php';


if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    $fechaOper = date('Y-m-d');
    $horaOper = date('H:i:s');
    $idUsuarioOper = $_POST['idUsuarioOper'];
}

// DATOS PEDIDOS POR POST
$idCliente = $_POST['idCliente'];
$estatus = $_POST['estatus'];

// OBTENER DATOS DEL CLIENTE
$obtenerDatosCliente = obtenerDatosCliente($dbConnect, 'idCliente', $idCliente);
$cliente = $obtenerDatosCliente['cliente'];

// CONDICION PARA CAMBIO DE ESTATUS
if ($estatus == 0) {
    $estatus = 1;
}else {
    $estatus = 0;
}

// ELIMINAR CLIENTE
$resultadoEliminarCliente = eliminarCliente($dbConnect, $estatus, $idCliente);
$arrayResultados = unirArrays($arrayResultados, $resultadoEliminarCliente);

// OBTENER DATOS DEL USUARIO LOGUEADO
$obtenerDatosUsuario = obtenerDatosUsuario($dbConnect, 'idUsuario', $idUsuarioOper);
$nombre = $obtenerDatosUsuario['nombres'];

// SE CREAL EL LOG DE MOVIMIENTOS
$idUsuario = NULL;
$idEmpresa = NULL;
$area = 'CLIENTES';
$detalleMovimiento = 'El usuario '.$nombre.' cambio de estatus al cliente '.$cliente;
$resultadoCrearLogMovimientos = crearLogMovimientos($dbConnect,$fechaOper,$horaOper,$idUsuario,$idUsuarioOper,$idEmpresa,$area,$detalleMovimiento);
$arrayResultados = unirArrays($arrayResultados, $resultadoCrearLogMovimientos);


if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Al cliente se le cambio su estatus correctamente.";
}else {
    $codigo = "fallo";
    $mensaje = "Error, el cliente no cambio el estatus";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
