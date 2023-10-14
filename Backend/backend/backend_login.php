<?php
require_once ("../db_funciones/db_global.php");
require_once ("../db_funciones/administracion/usuarios/db_usuarios.php");
require_once ("../db_funciones/db_commited_rolledback.php");
require_once ("../utilidades/funciones_utilidades.php");

if(!isset($backendIncluido)){

    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
}

// DATOS PEDIDOS POR POST
$usuario = $_POST['usuario'];
$contrasena = $_POST['password'];

// OBTENEMOS LOS DATOS PARA EL INICIO DE SESION
$datosUsuario = inciarSesionUsuario($dbConnect, 'usuario', $usuario, $contrasena);
// EVALUAMOS QUE NO VENGA VACIO
if (!empty($datosUsuario)) {
    $idUsuario    = $datosUsuario['idUsuario'];
    $codigo = "exito";
    $mensaje = "Ingreso de sesion correcta";

    // INICIAMOS UNA SESION Y ALGUNAS VARIABLES DE SESION QUE OCUPAREMOS
    session_start();
    $_SESSION['activa'] = true;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['idUsuario'] = $idUsuario;
    $_SESSION['nombreUsuario'] = $datosUsuario['nombres'];
    $_SESSION['apellidoUsuario'] = $datosUsuario['apellidos'];
    $_SESSION['idUsuarioCategoria'] = $datosUsuario['idUsuarioCategoria'];


} else {
    $codigo = "fallo";
    $mensaje = "Datos Incorrectos";
    $objetoRespuesta = array();
}

if(!isset($backendIncluido))
cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
?>
