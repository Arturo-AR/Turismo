<?php

/*
************************************************************************************************************************
INDICE FUNCIONES
mostrarClientes($dbConnect)
obtenerDatosCliente($dbConnect, $campo, $valor)
clienteRegistrar($dbConnect, $cliente, $rfc, $telefono, $correo)
actualizarDatosCliente($dbConnect, $cliente, $rfc, $telefono, $correo, $idCliente)
************************************************************************************************************************
*/

function mostrarClientes($dbConnect)
{
    $respuesta = array();
    $query = 'SELECT * FROM cliente';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }

    return $respuesta;
}

function obtenerDatosAtencion($dbConnect, $campo, $valor)
{
    $fila = array();
    $query = 'SELECT * FROM atencion WHERE ' . $campo . ' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;

}

function obtenerDatosCliente($dbConnect, $campo, $valor)
{
    $fila = array();
    $query = 'SELECT * FROM cliente WHERE ' . $campo . ' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    return $fila;

}

function atencionRegistrar($dbConnect, $nombre, $telefono, $correo)
{
    $query = 'INSERT INTO atencion (nombre, telefono, correo) VALUES (?,?,?)';
    $stmt = $dbConnect->prepare($query);
    if (!$stmt) {
        die('Error al preparar la declaración: ' . $dbConnect->error);
    }
    $stmt->bind_param('sss', $nombre, $telefono, $correo);
    $resultado = $stmt->execute();
    // Verificar si la declaración se ejecutó correctamente
    if (!$resultado) {
        die('Error al ejecutar la declaración: ' . $stmt->error);
    }
    $idAtencion = mysqli_insert_id($dbConnect);
    // Cerrar la declaración SQL
    $stmt->close();
    // Devolver un mensaje de éxito
    return $idAtencion;
}

function clienteRegistrar($dbConnect, $cliente, $rfc, $telefono, $correo)
{
    $query = 'INSERT INTO cliente (cliente, rfc, telefono, correo) VALUES (?,?,?,?)';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ssss', $cliente, $rfc, $telefono, $correo);
    return array(array($stmt->execute()), $stmt->insert_id);
}

?>
