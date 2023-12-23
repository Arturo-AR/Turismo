<?php

/*
***********************************************************************
INDICE OPC
L = Login
PM = País Mostrar
EM = Estado Mostrar
CM = Ciudad Mostrar
LM = Lugar Mostrar
***********************************************************************
*/

$parhash			= array_key_exists("st", $_GET)  ? htmlspecialchars($_GET["st"])   : "";
$partimeunix		= array_key_exists("t", $_GET)  ? htmlspecialchars($_GET["t"])    : "";
$opc				= array_key_exists("opc", $_GET)  ? htmlspecialchars($_GET["opc"])    : "";
$platformType		= array_key_exists("platformType", $_GET)  ? htmlspecialchars($_GET["platformType"])    : "";

$response = array();

if($opc == 'L'){
    /*DATOS OBLIGATORIOS EN EL POST*/
    // $_POST['usuario'];
    // $_POST['token'];
    // $_POST['idPuntoVenta'];

    require_once('../Backend/backend/usuarios/backend_login.php');
}elseif ($opc == 'PM') {
    require_once('../Backend/backend/lugares/backend_pais_mostrar.php');
}elseif ($opc == 'EM') {
    require_once('../Backend/backend/lugares/backend_estado_mostrar.php');
}elseif ($opc == 'CM') {
    require_once('../Backend/backend/lugares/backend_ciudad_mostrar.php');
}elseif ($opc == 'LM') {
    require_once('../Backend/backend/lugares/backend_lugar_mostrar.php');
}

echo json_encode($response, JSON_ERROR_UTF8);