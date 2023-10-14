<?php

/*
************************************************************************************************************************
INDICE FUNCIONES
construirFiltroTablaBusqueda($valorCampo, $filtros, $campoDb, $like)
buscar_en_tabla($dbConnect, $campos, $camposSelect, $tabla, $filtros, $visibles, $tipoSalida)
************************************************************************************************************************
*/

function buscarEnTabla($dbConnect, $campos, $camposSelect, $tabla, $filtros, $visibles, $posicionesStyle, $columnaTotales, $tipoSalida){
    $auxCampos = "";
    for($i = 0; $i < count($campos); $i++){
      if($auxCampos != ""){
        $auxCampos = $auxCampos.", ";
      }
      $auxCampos = $auxCampos.$campos[$i];
    }
  
    $query = "SELECT $camposSelect FROM $tabla $filtros";
    //echo ($query);
    //if($stmt =$dbConnect->prepare($query)){}else{echo "Errormesage: %s\n".$dbConnect->error;}
    $stmt  = $dbConnect->prepare($query);
    $stmt->execute();
    
    $result = $stmt->get_result();
  
    $busqueda = array(
      "pos"             => count($campos),
      "visibles"        => $visibles,
      ///"posicionId"      => $posicionId,
      "posicionesStyle" => $posicionesStyle,
      "columnaTotales"  => $columnaTotales,
      "encabezados"     => array(),
      "resultados"      => array(
        0 => array()
      )
    );
  
    for($i = 0; $i < count($campos); $i++){
      $busqueda["encabezados"]["campo ".($i)] = $campos[$i];
    }
  
    $j = 0;
    while($row = $result->fetch_assoc()){
      for($i = 0; $i < count($campos); $i++){
        $busqueda["resultados"][$j]["campo ".($i)] = $row[$campos[$i]];
      }
      $j++;
    }
  
    if($tipoSalida == "echo"){
        if($j > 0){
        $busqueda = json_encode($busqueda, JSON_ERROR_UTF8, 512);
        echo $busqueda;
      }
      else{
        echo "noResultados";
      }
    }
    else{
        if($j > 0){
        return $busqueda;
      }
      else{
        return "noResultados";
      }
    }
  }


  function construirFiltroTablaBusqueda($valorCampo, $filtros, $campoDb, $like){
    $filtrosAux = "";
    $valorCampoAux = "";
  
  
      if($like){
        $valorCampoAux = " LIKE '%".$valorCampo."%'";
      }else{
        $valorCampoAux = " = '".$valorCampo."' ";
      }
  
      if($valorCampo != "" ){
  
        if($filtros == "") {
          $filtrosAux .= " WHERE ";
        }else{
          $filtrosAux .= " AND ";
        }
  
        $filtrosAux .= $campoDb.$valorCampoAux;
      }
        return $filtrosAux;
  
  }


?>