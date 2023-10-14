<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_global.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/administracion/usuarios/db_usuarios.php';

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

$idUsuario = $_POST['idUsuario'];
$resultadoMostrarUsuarios = obtenerDatosUsuario($dbConnect, 'idUsuario', $idUsuario);
if (!empty($resultadoMostrarUsuarios)) {
    $objetoRespuesta['datos']['usuario'] = $resultadoMostrarUsuarios['usuario'];
    $objetoRespuesta['datos']['password'] = $resultadoMostrarUsuarios['password'];
    $objetoRespuesta['datos']['nombres'] = $resultadoMostrarUsuarios['nombres'];
    $objetoRespuesta['datos']['apellidos'] = $resultadoMostrarUsuarios['apellidos'];
    $objetoRespuesta['datos']['telefono'] = $resultadoMostrarUsuarios['telefono'];
    $objetoRespuesta['datos']['email'] = $resultadoMostrarUsuarios['email'];
    $objetoRespuesta['datos']['idUsuarioCategoria'] = $resultadoMostrarUsuarios['idUsuarioCategoria'];
    $objetoRespuesta['datos']['usuario'] = $resultadoMostrarUsuarios['usuario'];
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
