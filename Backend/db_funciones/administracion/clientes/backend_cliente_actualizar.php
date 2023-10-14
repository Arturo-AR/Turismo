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


$idCliente = $_POST['idCliente'];

// SE OBTIENEN LOS DATOS DEL CLIENTE
$obtenerDatosCliente = obtenerDatosCliente($dbConnect, 'idCliente', $idCliente);

// ACTUALIZAR CLIENTE
if (!empty($obtenerDatosCliente)) {
    $cliente  = existeCampoPost($_POST, 'cliente', $obtenerDatosCliente['cliente']);
    $rfc = existeCampoPost($_POST, 'rfc', '');
    $telefono = existeCampoPost($_POST, 'telefono', '');
    $correo = existeCampoPost($_POST, 'correo', '');

    $resultadoActualizarDatosCliente = actualizarDatosCliente($dbConnect, $cliente, $rfc, $telefono, $correo, $idCliente);
    $arrayResultados                 = unirArrays($arrayResultados, $resultadoActualizarDatosCliente);
}

// OBTENEMOS LOS DATOS DE USUARIO
$obtenerDatosUsuario = obtenerDatosUsuario($dbConnect, 'idUsuario', $idUsuarioOper);
$nombre = $obtenerDatosUsuario['nombres'];

// CREAR LOG DE MOVIMIENTOS
$idUsuario = NULL;
$idEmpresa = NULL;
$area = 'CLIENTES';
$detalleMovimiento = 'El usuario '.$nombre.' actualizó al cliente '.$cliente;
$resultadoCrearLogMovimientos = crearLogMovimientos($dbConnect,$fechaOper,$horaOper,$idUsuario,$idUsuarioOper,$idEmpresa,$area,$detalleMovimiento);
$arrayResultados = unirArrays($arrayResultados, $resultadoCrearLogMovimientos);


if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Cliente actualizado correctamente";
}else {
    $codigo = "fallo";
    $mensaje = "Error, cliente no actualizado";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
