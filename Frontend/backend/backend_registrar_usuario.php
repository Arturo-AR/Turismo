<?php
require_once ("../db_functions/db_global.php");
require_once ("../db_functions/db_commited_rolledback.php");
require_once ("../utilidades/funciones_utilidades.php");
require_once ("../db_functions/db_usuarios.php");
require_once ("../db_functions/db_usuario_conciliador.php");
require_once ("../db_functions/db_usuario_auxiliar.php");
require_once ("../db_functions/db_usuario_recepcion.php");
require_once ("../db_functions/db_usuario_estadistica.php");
require_once ("../db_functions/db_usuario_notificador.php");

if(!isset($backendIncluido)){
    $dbConnect            = comenzarConexion();
    $ejecutarDb           = true;
    $arrayResultados      = array();
    $objetoRespuesta      = array();
    $codigo               = '';
    $mensaje              = '';
    $fechaAlta            = date('Y-m-d');
    $horaOper             = date('H:i:s');
}

// ===================================================================================================



// DATOS PEDIDOS POR POST
$nombres   = ucwords($_POST['nombres']);
$apellidos = ucwords($_POST['apellidos']);
$usuario   = $_POST['usuario'];
$password  = $_POST['password'];
$tipo      = $_POST['tipo'];
$ciudad    = $_POST['ciudad'];

// SE REGISTRA AL USUARIO
$resultadoUsuarioRegistro  = registrarUsuario($dbConnect, $nombres, $apellidos, $usuario, $password, $tipo, $ciudad, $fechaAlta);
$arrayResultados           = unirArrays($arrayResultados, $resultadoUsuarioRegistro);

$resultadoMostrarUltimoUsuarioCreado = obtenerUltimoUsuarioCredo($dbConnect);
$idUsuario = $resultadoMostrarUltimoUsuarioCreado["ultimo_id"];



// if (isset($idUsuario)) {
//     if ($tipo == 4) {
//         $resultadoUsuarioRecepcionRegistro = registrarUsuarioRecepcion($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad);
//         // $arrayResultados                   = unirArrays($arrayResultados, $resultadoUsuarioRecepcionRegistro);
//         // print_r($arrayResultados);
//     }
// }

if ($tipo == 2){ //tipo 2 es conciliador

    // SE REGISTRA EN LA TABLA DEL TIPO DEL USUARIO CONCILIADOR
    $resultadoUsuarioConciliadorRegistro  = registrarUsuarioConciliador($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad);
}
elseif ($tipo == 3){ // tipo 3 es auxiliar

    $idUsuarioConciliador = $_POST['idUsuarioConciliador'];

    // SE REGISTRA EN LA TABLA DEL TIPO DEL USUARIO AUXILIAR
    $resultadoUsuarioAuxiliarRegistro  = registrarUsuarioAuxiliar($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad, $idUsuarioConciliador);

}
elseif ($tipo == 4){ //tipo 4 es recepcion

    // SE REGISTRA EN LA TABLA DEL TIPO DEL USUARIO RECEPCION
    $resultadoUsuarioRecepcionRegistro = registrarUsuarioRecepcion($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad);
}
elseif ($tipo == 5){ //tipo 5 es estadistica

    // SE REGISTRA EN LA TABLA DEL TIPO DEL USUARIO RECEPCION
    $resultadoUsuarioEstadisticaRegistro = registrarUsuarioEstadistica($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad);
}
elseif ($tipo == 6) {

    $idTipoNotificador = $_POST["idTipoNotificador"];

    // SE REGISTRA EN LA TABLA DEL TIPO DEL USUARIO NOTIFICADOR
    $resultadoUsuarioNotificadorRegistro  = registrarUsuarioNotificador($dbConnect, $idUsuario, $nombres, $apellidos, $ciudad, $idTipoNotificador);
}

    
if(!isset($backendIncluido)){
    $ejecutarDb   = true;
    $respuesta    = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo       = "exito";
    $mensaje      = "Usuario registrado correctamente";
}else {
    $codigo = "fallo";
    $mensaje = "Error usuario no registrado";
    $objetoRespuesta = array();
}


//******************************************************************************************************
if(!isset($backendIncluido))
cerrarConexion($dbConnect);
//******************************************************************************************************
//******************************************************************************************************
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
//******************************************************************************************************

?>