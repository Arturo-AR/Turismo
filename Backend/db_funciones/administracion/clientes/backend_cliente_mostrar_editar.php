<?php

require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_global.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/clientes/db_clientes.php';

if (!isset($backendIncluido)) {
    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $arrayResultados = array();
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
    $fechaOper  = date('Y/m/d');
    $horaOper = date('H:s:i');
}

// OBTENER DATOS DEL PRODUCTO POR SU ID
$idCliente = $_POST['idCliente'];
$resultadoMostrarCliente = obtenerDatosCliente($dbConnect, 'idCliente', $idCliente);

// MOSTRAR LOS DATOS EN UN OBJETO RESPUESTA
if (!empty($resultadoMostrarCliente)) {
  $objetoRespuesta['datos']['cliente'] = $resultadoMostrarCliente['cliente'];
  $objetoRespuesta['datos']['rfc'] = $resultadoMostrarCliente['rfc'];
  $objetoRespuesta['datos']['telefono'] = $resultadoMostrarCliente['telefono'];
  $objetoRespuesta['datos']['correo'] = $resultadoMostrarCliente['correo'];
} else {
  $codigo = "fallo";
  $mensaje = "No hay datos de cliente";
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
