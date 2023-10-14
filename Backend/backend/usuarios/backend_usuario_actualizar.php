<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_commited_rolledback.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utilidades/funciones_utilidades.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db_funciones/db_log_movimientos.php';
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
    $usuarioOper          = $_POST['idUsuarioOper'];
}
$idUsuario = $_POST['idUsuario'];
$resultadoObtenerDatos = obtenerDatosUsuario($dbConnect,'idUsuario',$idUsuario);
$nombreUsuario = $resultadoObtenerDatos['nombres'];
$usuario = $resultadoObtenerDatos['usuario'];

if (!empty($resultadoObtenerDatos)) {
    $usuario = existeCampoPost($_POST,'usuario',$resultadoObtenerDatos['usuario']);
    $password = existeCampoPost($_POST,'password',$resultadoObtenerDatos['password']);
    $nombres = existeCampoPost($_POST,'nombres',$resultadoObtenerDatos['nombres']);
    $apellidos = existeCampoPost($_POST,'apellidos',$resultadoObtenerDatos['apellidos']);
    $telefono = existeCampoPost($_POST,'telefono',$resultadoObtenerDatos['telefono']);
    $email = existeCampoPost($_POST,'email',$resultadoObtenerDatos['email']);
    $idUsuarioCategoria = existeCampoPost($_POST,'idUsuarioCategoria',$resultadoObtenerDatos['idUsuarioCategoria']);

    $resultadoActualizarusuario = actualizarDatosUsuario($dbConnect, $usuario, $password, $nombres, $apellidos, $telefono, $email, $idUsuarioCategoria, $idUsuario);
    $arrayResultados = unirArrays($arrayResultados,$resultadoActualizarusuario);
}

// LOG DE MOVIMIENTOS
$idEmpresa = NULL;
$area = "USUARIOS";
$detalleMovimiento = $nombreUsuario." Actualizó el usuario: ".$usuario;
$crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $usuarioOper, $idEmpresa, null, $area, $detalleMovimiento);
$arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);

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
