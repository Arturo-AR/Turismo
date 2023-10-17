<?php

$verificado = false;
$codigo     = 'fallo';
$mensaje    = 'Acceso Restringido';

date_default_timezone_set('America/Mexico_City');

$sessionActivada = session_status() == PHP_SESSION_ACTIVE ? TRUE : FALSE;

if($sessionActivada === FALSE){
  session_start();
}

if(!isset($_SESSION)){
  session_start();
  session_regenerate_id();
}

if(isset($_SESSION['activa'])){

  if(isset($home)){

    if($home){
      header("Location: ../forms");
      exit();
    }

  }

}
else if(!isset($_SESSION['activa'])){// si no se cuenta con sesión activa

  if(isset($needSession)){// Funciona para ver si se requiere sesión para el acceso en front

    if($needSession){
      header("Location: ../");
      exit();
    }
  }

}

?>
