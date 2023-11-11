<?php

/*
***********************************************************************
INDICE FUNCIONES
crearLogMovimientos($dbConnect, $fechaOper, $horaOper, $idUsuario, $area, $detalleMovimiento)
mostrarLogMovimientos($dbConnect)
***********************************************************************
*/

function crearLogMovimientos($dbConnect,$fechaOper,$horaOper,$idUsuario,$idUsuarioOper,$idEmpresa,$area,$detalleMovimiento){
    $query = 'INSERT INTO log_movimientos (fechaOper,horaOper,idUsuario,idUsuarioOper,idEmpresa,area,detalleMovimiento) VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ssiiiss',$fechaOper,$horaOper,$idUsuario,$idUsuarioOper,$idEmpresa,$area,$detalleMovimiento);
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

function mostrarLogMovimientosCotizacion($dbConnect, $campo = null, $valor = null) {
    $filas = array();
    $query = "SELECT log.idMovimiento AS 'idMovimiento' , log.fechaOper AS 'fechaOper',log.horaOper AS 'horaOper',
        log.idCotizacion AS 'idCotizacion', pro.proveedor AS 'proveedor', emp.nombre AS 'empresa', ate.nombre AS 'atencion'
        FROM log_movimientos log
        INNER JOIN cotizacion cot ON log.idCotizacion = cot.id
        INNER JOIN proveedor pro ON pro.idProveedor = cot.id_empresa
        INNER JOIN empresa emp ON emp.id_empresa = cot.id_cliente
        INNER JOIN atencion ate ON ate.idAtencion = cot.id_atencion";
    if ($campo != null && $valor != null) {
        $query .= ' WHERE log.' . $campo . ' = ?';
    }
    $stmt = $dbConnect->prepare($query);
    if ($campo != null && $valor != null) {
        $stmt->bind_param('s', $valor);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
    }
    return $filas;
}

?>
