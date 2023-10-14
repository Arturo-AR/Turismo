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
$cliente = $_POST['cliente'];
$rfc = $_POST['rfc'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

// SE REGISTRA AL CLIENTE Y SE OBTIENE SU ID
$resultadoClienteRegistrar = clienteRegistrar($dbConnect, $cliente, $rfc, $telefono, $correo);
$arrayResultados = unirArrays($arrayResultados, $resultadoClienteRegistrar);

// SE CONSULTAN LOS DATOS DE USUARIO PARA OBTENER EL NOMBRE (EN ESTE CASO)
$obtenerDatosUsuario = obtenerDatosUsuario($dbConnect, 'idUsuario', $idUsuarioOper);
$nombre = $obtenerDatosUsuario['nombres'];

// SE CREAL EL LOG DE MOVIMIENTOS
$idUsuario = NULL;
$idEmpresa = NULL;
$area = 'CLIENTES';
$detalleMovimiento = 'El usuario '.$nombre.' registró al usuario '.$cliente;
$resultadoCrearLogMovimientos = crearLogMovimientos($dbConnect,$fechaOper,$horaOper,$idUsuario,$idUsuarioOper,$idEmpresa,$area,$detalleMovimiento);
$arrayResultados = unirArrays($arrayResultados, $resultadoCrearLogMovimientos);


if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Cliente registrado correctamente";
}else {
    $codigo = "fallo";
    $mensaje = "Error cliente no registrado";
    $objetoRespuesta = array();
}
if (!isset($backendIncluido))
    cerrarConexion($dbConnect);

echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
