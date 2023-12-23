<?php

// ============================================== Country ==============================================
function registrarCountry($dbConnect, $countryName) {
    $query = "INSERT INTO country (countryName)
              VALUES (?)";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $countryName);
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerInfoCountry($dbConnect, $campo, $valor) {
    $fila = array();
    $query = 'SELECT countryID, countryName FROM country WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function actualizarCountry($dbConnect, $countryName, $countryID) {
    $query = 'UPDATE country SET countryName = ? WHERE countryID = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('si', $countryName, $countryID);
    return array($stmt->execute());
}

function obtenerInfoTotalCountry($dbConnect) {
    $respuesta = array();
    $query = "SELECT countryID, countryName FROM country WHERE removed = 0";
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

// ============================================== State ==============================================
function registrarState($dbConnect,$stateName, $countryID) {
    $query = "INSERT INTO state (stateName, countryID)
              VALUES (?,?)";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('si', $stateName,$countryID);
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerInfoState($dbConnect, $campo, $valor) {
    $respuesta = array();
    $query = 'SELECT stateID, stateName, countryID FROM state WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function actualizarState($dbConnect, $stateName, $countryID, $stateID) {
    $query = 'UPDATE state SET stateName = ?, countryID = ? WHERE stateID = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sii', $stateName, $countryID, $stateID);
    return array($stmt->execute());
}

// ============================================== Town ==============================================
function registrarTown($dbConnect,$townName, $stateID) {
    $query = "INSERT INTO town (townName, stateID)
              VALUES (?,?)";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('si', $townName,$stateID);
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerInfoTown($dbConnect, $campo, $valor) {
    $respuesta = array();
    $query = 'SELECT townID, townName, stateID FROM town WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function actualizarTown($dbConnect, $townName, $stateID, $townID) {
    $query = 'UPDATE town SET townName = ?, stateID = ? WHERE townID = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sii', $townName, $stateID, $townID);
    return array($stmt->execute());
}

// ============================================== Places ==============================================
function registrarPlace($dbConnect, $placeName, $placeDescription, $placeImage, $townID) {
    $query = "INSERT INTO places (placeName, placeDescription, placeImage, townID)
              VALUES (?,?,?,?)";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sssi', $placeName, $placeDescription, $placeImage, $townID);
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerInfoPlace($dbConnect, $campo, $valor) {
    $respuesta = array();
    $query = 'SELECT placeID, placeName, placeDescription, placeImage, townID FROM places WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}


// function userDelete($dbConnect, $eliminado, $userID) {
//     $query = 'UPDATE users SET eliminado = ? WHERE userID = ?';
//     $stmt = $dbConnect->prepare($query);
//     $stmt->bind_param('ii', $eliminado, $userID);
//     return array($stmt->execute());
// }

?>
