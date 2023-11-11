<?php

function existeCampoPost($arregloPost, $campo, $valorSiNoExiste){

  if(empty($arregloPost[$campo])){
    $resultado = $valorSiNoExiste;
  }else{
    $resultado = $arregloPost[$campo];
  }
  return $resultado;
}

/* <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<REVISAR UTILIDAD>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
function formatoFiltros($filtros, $comparasion = 'LIKE'){
    $filtros = json_decode($_POST['filtros'], true);
    $llaves_filtros = array_keys($filtros);
    $filtro = '';

    foreach($llaves_filtros as $llave){
        if(empty($filtro)){
            if($comparasion == 'LIKE'){
                $filtro = 'WHERE '.$llave.' LIKE \''.$filtros[$llave].'%\'';
            }
        }else{
            if($comparasion == 'LIKE'){
                $filtro = $filtro.'AND '.$llave.' LIKE \''.$filtros[$llave].'%\'';
            }
        }
    }

    return $filtro;
}
/* <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<REVISAR UTILIDAD>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */


function constructorRespuesta($codigo, $mensaje, $objetoRespuesta){
  $respuesta = array();
  $respuesta['codigo']            = $codigo;
  $respuesta['mensaje']           = $mensaje;
  $respuesta['objetoRespuesta']   = $objetoRespuesta;
  return $respuesta;
}

function unirArrays($arrayOriginal, $arrayAUnir){

  for($i = 0; $i < count($arrayAUnir); $i++){
    $arrayOriginal[] = $arrayAUnir[$i];
  }

  return $arrayOriginal;
}

function cadenaAleatoria($caracteres, $longitud){

  $tamanoVariable = strlen($caracteres);
  $cadena = '';

  for( $x = 0; $x < $longitud; $x++ ) {  
    $caracterAleatorio = $caracteres[ random_int( 0, $tamanoVariable - 1 ) ];
    $cadena .= $caracterAleatorio;
  }

  return $cadena;
}
?>
