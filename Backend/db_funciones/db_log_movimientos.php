<?php

/*
***********************************************************************
INDICE FUNCIONES
crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $area, $detalleMovimiento)
mostrarLogMovimientos($dbConnect)
***********************************************************************
*/

function crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $idUsuarioOper, $idEmpresa, $idCotizacion, $area, $detalleMovimiento){
    $query = 'INSERT INTO log_movimientos (fechaOper, horaOper, idUsuario, idUsuarioOper, idEmpresa, idCotizacion, area, detalleMovimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ssiiiiss', $fechaOper, $horaOper, $idUsuario, $idUsuarioOper, $idEmpresa, $idCotizacion, $area, $detalleMovimiento);
    return array($stmt->execute());
}

function mostrarLogMovimientos($dbConnect){
    $respuesta = array();
    $query = 'SELECT * FROM log_movimientos ORDER BY idMovimiento DESC LIMIT 10';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($fila = $resultado->fetch_assoc()){
      array_push($respuesta, $fila);
      }

      return $respuesta;
}

?>
