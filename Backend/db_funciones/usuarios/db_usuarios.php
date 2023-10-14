<?php

function inicialRegistro($dbConnect) {
	$query = "SELECT COUNT(*) AS 'noRegistros' FROM usuarios ";
	$stmt  = $dbConnect->prepare($query);
	$stmt->execute();
    $resultado = $stmt->get_result();
	$respuesta = $resultado->fetch_assoc();
	return $respuesta;
}

function inciarSesionUsuario($dbConnect, $campo, $valor, $contrasena) {
    $fila = array();
    $query = 'SELECT * FROM usuarios WHERE '.$campo.' = ? AND password = ? AND eliminado = 0';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ss', $valor, $contrasena);
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
    $query = "SELECT * FROM usuarios";
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function obtenerDatosUsuario($dbConnect, $campo, $valor) {
    $fila = array();
    $query = 'SELECT usuario as "usuario", password as "password", nombres as "nombres", apellidos as "apellidos", telefono as "telefono", email as "email", idUsuariocategoria as "idUsuarioCategoria", usuario as "usuario" FROM usuarios WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function obtenerDatosUsuarioCategoria($dbConnect) {
    $respuesta = array();
    $query = 'SELECT * FROM usuario_categoria';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function actualizarDatosUsuario($dbConnect, $usuario, $password, $nombres, $apellidos, $telefono, $email, $idUsuarioCategoria, $idUsuario) {
    $fila = array();
    $query = 'UPDATE usuarios SET usuario = ?, password = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, idUsuarioCategoria = ? WHERE idUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ssssssii', $usuario, $password, $nombres, $apellidos, $telefono, $email, $idUsuarioCategoria, $idUsuario);
    return array($stmt->execute());
}

function eliminarUsuario($dbConnect, $estatus, $idUsuario) {
    $query = 'UPDATE usuarios SET eliminado = ? WHERE idUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ii', $estatus, $idUsuario);
    return array($stmt->execute());
}

function cambioContrasenia($dbConnect,$password,$idUsuario) {
    $query = "UPDATE usuarios SET password = ? WHERE idUsuario = ? ";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('si',$password,$idUsuario);
    return array($stmt->execute());
}

?>
