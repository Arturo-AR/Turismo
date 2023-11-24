<?php

require_once ("../../db_funciones/db_global.php");
require_once ("../../db_funciones/usuarios/db_usuarios.php");
require_once ("../../db_funciones/db_commited_rolledback.php");
require_once ("../../utilidades/funciones_utilidades.php");

if(!isset($backendIncluido)){

    $dbConnect = comenzarConexion();
    $ejecutarDb = true;
    $objetoRespuesta = array();
    $codigo = '';
    $mensaje = '';
}

// POST TEST
// $userID    = 1;
// $platformType = 'web';
// $userEmail = 'Test';
// $password  = 'Test';

// DATOS PEDIDOS POR POST
$userEmail = $_POST['userEmail'];
$password  = $_POST['userPassword'];
$platformType = $_POST['platformType'];

// OBTENEMOS LOS DATOS PARA EL INICIO DE SESION
$datosUsuario = inciarSesionUsuario($dbConnect, 'userEmail', $userEmail, $password);
 // EVALUAMOS QUE NO VENGA VACIO
 if (!empty($datosUsuario)) {
    $userID    = $datosUsuario['userID'];
    $codigo       = "exito";
    $mensaje      = "Ingreso de sesion correcta";

    if ($platformType == 'web') {

            // INICIAMOS UNA SESION Y ALGUNAS VARIABLES DE SESION QUE OCUPAREMOS
            session_start();
            $_SESSION['activa'] = true;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userID'] = $userID;
            $_SESSION['userFirstName'] = $datosUsuario['userFirstName'];
            $_SESSION['userLastName'] = $datosUsuario['userLastName'];
            // $_SESSION['idUsuarioCategoria'] = $datosUsuario['idUsuarioCategoria'];

    }elseif ($platformType == 'app') {
        $objetoRespuesta['userID'] = $userID;
        $objetoRespuesta['userName'] = $datosUsuario['userFirstName'];
        $mensaje = 'Inicio';
    }

} else {
    $codigo = "fallo";
    $mensaje = "Datos Incorrectos";
    $objetoRespuesta = array();
}

if(!isset($backendIncluido))
cerrarConexion($dbConnect);
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
?>
