<?php

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


}

echo json_encode($response, JSON_ERROR_UTF8);