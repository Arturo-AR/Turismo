<?php

function inicialRegistro($dbConnect) {
	$query = "SELECT COUNT(*) AS 'noRegistros' FROM usuarios ";
	$stmt  = $dbConnect->prepare($query);
	$stmt->execute();
    $resultado = $stmt->get_result();
	$respuesta = $resultado->fetch_assoc();
	return $respuesta;
}

function inciarSesionUsuario($dbConnect, $campo, $valor, $password) {
    $fila = array();
    $query = 'SELECT * FROM users WHERE '.$campo.' = ? AND userPassword = ? AND eliminado = 0';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ss', $valor, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function registrarUsuario($dbConnect,$userFirstName,$userLastName,$userEmail,$userPassword,$userPhoneNumber,$userAge) {
    $query = "INSERT INTO users (userFirstName,userLastName,userEmail,userPassword,userPhoneNumber,userAge)
              VALUES (?,?,?,?,?,?)";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sssssi', $userFirstName, $userLastName, $userEmail, $userPassword, $userPhoneNumber, $userAge);
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerDatosTodosUsuarios($dbConnect) {
    $respuesta = array();
    // $query      = "SELECT * FROM usuarios WHERE eliminado = 0";
    $query = "SELECT * FROM users";
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function GetUserInfo($dbConnect, $campo, $valor) {
    $fila = array();
    $query = 'SELECT userFirstName as "userFirstName", userLastName as "userLastName", userEmail as "userEmail", 
    userPassword as "userPassword", userPhoneNumber as "userPhoneNumber", userAge as "userAge" 
    FROM users WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

// function obtenerDatosUsuarioCategoria($dbConnect) {
//     $respuesta = array();
//     $query = 'SELECT * FROM usuario_categoria';
//     $stmt = $dbConnect->prepare($query);
//     $stmt->execute();
//     $resultado = $stmt->get_result();
//     while ($fila = $resultado->fetch_assoc()) {
//         array_push($respuesta, $fila);
//     }
//     return $respuesta;
// }

function updateUserInfo($dbConnect, $userFirstName, $userLastName, $userEmail, $userPassword, $userPhoneNumber, $userAge, $userID) {
    $query = 'UPDATE users SET userFirstName = ?, userLastName = ?, userEmail = ?, userPassword = ?, userPhoneNumber = ?, userAge = ? 
    WHERE userID = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sssssii', $userFirstName, $userLastName, $userEmail, $userPassword, $userPhoneNumber, $userAge, $userID);
    return array($stmt->execute());
}

function userDelete($dbConnect, $eliminado, $userID) {
    $query = 'UPDATE users SET eliminado = ? WHERE userID = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ii', $eliminado, $userID);
    return array($stmt->execute());
}

// function cambioContrasenia($dbConnect,$password,$idUsuario) {
//     $query = "UPDATE usuarios SET password = ? WHERE idUsuario = ? ";
//     $stmt = $dbConnect->prepare($query);
//     $stmt->bind_param('si',$password,$idUsuario);
//     return array($stmt->execute());
// }

?>
