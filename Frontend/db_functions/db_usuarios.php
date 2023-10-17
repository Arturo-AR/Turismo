<?php
/*
************************************************************************************************************************
INDICE FUNCIONES
inciarSesionUsuario($dbConnect, $campo, $valor, $contrasena
registrarUsuario($conn,$password,$nombres,$apellidos,$telefono,$email,$fechaAlta,$idUsuarioCategoria)
obtenerDatosUsuario($dbConnect, $campo, $valor)
actualizarDatosUsuario($dbConnect, $nombres, $apellidos, $telefono, $email, $idUsuario)
eliminarUsuario($dbConnect, $estatus, $idUsuario)
cambioContrasenia($dbConnect,$password,$idUsuario)
************************************************************************************************************************
*/


function inciarSesionUsuario($dbConnect, $campo, $valor, $contrasena){
    $fila = array();
    $query = 'SELECT * FROM usuarios WHERE '.$campo.' = ? AND password = ? AND eliminado = 0';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ss', $valor, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    return $fila;
}

function registrarUsuario($dbConnect, $nombres, $apellidos, $usuario, $password, $tipo, $ciudad, $fechaAlta){
    $query = 'INSERT INTO usuarios (nombres, apellidos, usuario, password, idTipoUsuario, idCiudad, fechaAlta)
    VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ssssiis', $nombres, $apellidos, $usuario, $password, $tipo, $ciudad, $fechaAlta);
    
    return array(array($stmt->execute()), $stmt->insert_id);
}

function obtenerDatosUsuarioCategoria($dbConnect){
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

function obtenerUsuarios($dbConnect){
    $respuesta = array();
    $query = 'SELECT us.idUsuario, us.nombres, us.apellidos, usca.tipoUsuario, ci.ciudad, us.idTipoUsuario FROM usuarios us 
    INNER JOIN usuario_categoria usca 
    INNER JOIN ciudad ci
    WHERE us.idTipoUsuario = usca.idTipoUsuario
    AND us.idCiudad = ci.idCiudad
    AND us.eliminado = 0';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }

    return $respuesta;
}

function obtenerDatosUsuario($dbConnect){
    $respuesta = array();
    $query = 'SELECT usu.idUsuario, usu.usuario, usu.nombres, usu.apellidos, usca.usuarioCategoria, usu.eliminado FROM usuarios usu INNER JOIN usuario_categoria usca WHERE usu.idUsuarioCategoria = usca.idUsuarioCategoria';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }

    return $respuesta;
}

function obtenerDatosUsuarioSeleccionado($dbConnect, $campo, $valor){
    $fila = array();
    $query = 'SELECT usu.idUsuario, usu.usuario, usu.password, usu.nombres, usu.apellidos, usca.idUsuarioCategoria, usca.usuarioCategoria, usu.eliminado FROM usuarios usu INNER JOIN usuario_categoria usca WHERE usu.idUsuarioCategoria = usca.idUsuarioCategoria AND '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function datosUsuarios($dbConnect, $campo, $valor){
    $fila = array();
    $query = 'SELECT * FROM usuarios WHERE '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function datosUsuariosAuxiliares($dbConnect, $campo, $valor){
    $fila = array();
    $query = 'SELECT
    u.usuario,
    u.idTipoUsuario,
    u.idCiudad,
    ua.nombres,
    ua.apellidos,
    ua.idUsuarioConciliador
    FROM
        usuarios u
    LEFT JOIN
        usuario_auxiliar ua ON u.idUsuario = ua.idUsuarioAuxiliar
    AND  u.'.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function datosUsuariosNotificadores($dbConnect, $campo, $valor){
    $fila = array();
    $query = 'SELECT
    u.usuario,
    u.idTipoUsuario,
    u.idCiudad,
    usno.nombres,
    usno.apellidos,
    usno.idTipoNotificador
    FROM
        usuario_notificador usno 
    INNER JOIN
        usuarios u ON u.idUsuario = usno.idUsuarioNotificador
    AND  u.'.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function obtenerDatosLogMovimiento($dbConnect, $campo, $valor){
    $fila = array();
    $query = 'SELECT usu.nombres, usu.apellidos, ci.ciudad FROM usuarios usu INNER JOIN ciudad ci WHERE ci.idCiudad = usu.idCiudad AND '.$campo.' = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

function eliminarUsuario($dbConnect, $estatus, $idUsuario){
    $query = 'UPDATE usuarios SET eliminado = ? WHERE idUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ii', $estatus, $idUsuario);
    return array($stmt->execute());
}

function cambioContrasenia($dbConnect, $password, $idUsuario){
    $query = "UPDATE usuarios SET password = ? WHERE idUsuario = ? ";
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('si', $password, $idUsuario);
    return array($stmt->execute());
}

function actualizarDatosUsuario($dbConnect, $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $idUsuario){
    $query = 'UPDATE usuarios SET nombres = ?, apellidos = ?, usuario = ?, idTipoUsuario = ?, idCiudad = ? WHERE idUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sssiii', $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $idUsuario);
    return array($stmt->execute());
}

function actualizarDatosUsuarioAuxiliar($dbConnect, $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $nombresAuxiliar, $apellidosAuxiliar, $ciudadAuxiliar, $idConciliador, $idUsuario){
    $query = 'UPDATE usuarios AS u
    JOIN usuario_auxiliar AS ua ON u.idUsuario = ua.idUsuarioAuxiliar
    SET
        u.nombres = ?,
        u.apellidos = ?,
        u.usuario = ?,
        u.idTipoUsuario = ?,
        u.idCiudad = ?,
        ua.nombres = ?,
        ua.apellidos = ?,
        ua.idCiudad = ?,
        ua.IdUsuarioConciliador = ?
    WHERE
        u.idUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('sssiisssii', $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $nombresAuxiliar, $apellidosAuxiliar, $ciudadAuxiliar, $idConciliador, $idUsuario);
    return array($stmt->execute());
}

// function actualizarDatosUsuarioNotificador($dbConnect, $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $idTipoNotificador, $idUsuario){
//     $query = 'UPDATE usuarios SET nombres = ?, apellidos = ?, usuario = ?, idTipoUsuario = ?, idCiudad = ?, idUsuarioConciliador = ? WHERE idUsuario = ?';
//     $stmt = $dbConnect->prepare($query);
//     $stmt->bind_param('sssiiii', $nombres, $apellidos, $usuario, $idTipoUsuario, $ciudad, $idConciliador, $idUsuario);
//     return array($stmt->execute());
// }

function obtenerUsuariosAuxiliaresCiudad($dbConnect, $idCiudad, $idTipoUsuario){
    $respuesta = array();
    $query = 'SELECT idUsuario FROM usuarios WHERE idCiudad = ? AND idTipoUsuario = ?';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ii', $idCiudad, $idTipoUsuario); 
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function obtenerUsuariosConRatificacion($dbConnect){
    $respuesta = array();
    $query = 'SELECT a.idUsuario 
    FROM usuarios AS a 
    INNER JOIN ratificacion AS r ON a.idUsuario = r.idUsuario 
    WHERE r.idUsuario IS NOT NULL;';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }

    return $respuesta;
}

function obtenerUsuariosSinRatificacion($dbConnect, $idCiudad, $idTipoUsuario){
    $respuesta = array();
    $query = 'SELECT a.idUsuario 
    FROM usuarios a 
    LEFT JOIN ratificacion r ON a.idUsuario = r.idUsuario 
    WHERE r.idUsuario IS NULL 
    AND idCiudad = ? 
    AND idTipoUsuario = ? 
    ORDER BY idUsuario';
    $stmt = $dbConnect->prepare($query);
    $stmt->bind_param('ii', $idCiudad, $idTipoUsuario); 
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        array_push($respuesta, $fila);
    }
    return $respuesta;
}

function obtenerUltimoUsuarioCredo($dbConnect){
    $fila = array();
    $query = 'SELECT MAX(idUsuario) AS ultimo_id FROM usuarios WHERE fechaAlta = CURDATE()';
    $stmt = $dbConnect->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}

?>