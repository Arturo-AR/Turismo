<?php

require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");
require_once ("../../db_funciones/db_log_movimientos.php");
require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");

if (!isset($backendIncluido)) {
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

//POST TEST
// $platformType       = 'app';
// $userFirstName      = 'Abdiel';
// $userLastName       = 'No se';
// $userEmail          = 'ab@nose';
// $userPassword       = '1234';
// $userPhoneNumber    = '2156349064';
// $userAge            = '20';

// $fechaAlta = date('Y/m/d');
$userFirstName      = ucwords($_POST['userFirstName']);
$userLastName       = ucwords($_POST['userLastName']);
$userEmail          = $_POST['userEmail'];
$userPassword       = $_POST['userPassword'];
$userPhoneNumber    = $_POST['userPhoneNumber'];
$userAge            = $_POST['userAge'];


$resultadoRegistrarUsuario = registrarUsuario($dbConnect,$userFirstName,$userLastName,$userEmail,$userPassword,$userPhoneNumber,$userAge);
$arrayResultados = unirArrays($arrayResultados,$resultadoRegistrarUsuario);
// $idUsuarioCreado = $resultadoRegistrarUsuario[1];

// LOG DE MOVIMIENTOS
// $resultadoObtenerDatosUsuario = obtenerDatosUsuario($dbConnect, 'idUsuario', $usuarioOper);
// $nombreUsuarioLogueado = $resultadoObtenerDatosUsuario['nombres'];
// $idEmpresa = NULL;
// $area = "USUARIOS";
// $detalleMovimiento = $nombreUsuarioLogueado." Registro un usuario: ".$usuario;
// $crearLogMovimientos = crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuarioCreado, $usuarioOper, $idEmpresa, $area, $detalleMovimiento);
// $arrayResultados = unirArrays($arrayResultados, $crearLogMovimientos);
if ($platformType == 'app') {
    $objetoRespuesta['registro'] = true;
}

if (!isset($backendIncluido)) {
    $ejecutarDb = true;
    $respuesta = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo = "exito";
    $mensaje = "Usuario registrado";
}else {
    $codigo = "fallo";
    $mensaje = "Usuario no creado";
    $objetoRespuesta = array();
}

if (!isset($backendIncluido))
    cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);


?>
