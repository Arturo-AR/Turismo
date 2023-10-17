<?php

function committedRolledbackDb($dbConnect, $array, $ejecutarDb, $objetoRespuesta, $mensaje){
  
//  echo "|".$ejecutarDb."|";
  $hacer = true;

  for($i = 0; $i < count($array); $i++){
    if(!$array[$i]){
      $hacer = false;
      break;
    }
  }

  if($hacer){
    if($ejecutarDb){

      $dbConnect->commit();
    }
    $respuesta = constructorRespuesta("exito", $mensaje, $objetoRespuesta);
  }
  else{
    if($ejecutarDb){
      $dbConnect->rollback();
    }
    $respuesta = constructorRespuesta("fallo", $mensaje, $objetoRespuesta);
  }
  return $respuesta;

}

?>
