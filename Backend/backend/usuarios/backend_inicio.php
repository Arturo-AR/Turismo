<?php
require_once ("../db_funciones/db_global.php");
require_once ("../db_funciones/db_commited_rolledback.php");
require_once ("../db_funciones/db_usuarios.php");
require_once ("../utilidades/funciones_utilidades.php");
    

if(!isset($backendIncluido)){
    $dbConnect            = comenzarConexion();
    $ejecutarDb           = true;
    $arrayResultados      = array();
    $objetoRespuesta      = array();
    $codigo = '';
    $mensaje = '';
}
    $resultadoInicial = inicialRegistro($dbConnect);

    if ($resultadoInicial['noRegistros'] == 0){
        echo "registrar usuario primera vez";
    } else {
        echo "envio al login";
    }



if(!isset($backendIncluido)){
    $ejecutarDb   = true;
    $respuesta    = committedRolledbackDb($dbConnect, $arrayResultados, $ejecutarDb, $objetoRespuesta, $mensaje);
    $codigo       = "exito";
    $mensaje      = "Usuario registrado";
  }else {
          $codigo = "fallo";
          $mensaje = "Usuario no creado";
          $objetoRespuesta = array();
      }

//***************************************************************************************************************
if(!isset($backendIncluido))
    cerrarConexion($dbConnect);
//***************************************************************************************************************
//***************************************************************************************************************
echo json_encode(constructorRespuesta($codigo, $mensaje, $objetoRespuesta), JSON_ERROR_UTF8);
//***************************************************************************************************************


?>
