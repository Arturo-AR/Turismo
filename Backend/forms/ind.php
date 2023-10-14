<?php
include '../db_funciones/db_global.php';
?>
<!doctype html>
<html lang="es">
    
    <head>
        
        <meta charset="utf-8">
        
        <title> Formulario de Acceso </title>    
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="author" content="Videojuegos & Desarrollo">
        <meta name="description" content="Muestra de un formulario de acceso en HTML y CSS">
        <meta name="keywords" content="Formulario Acceso, Formulario de LogIn">
        
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="estilos/login.css">
        
        <style type="text/css">
            
        </style>
        
        <script type="text/javascript">
        
        </script>
        
    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light iconoInicio" id="menuNavegacion">
          <a class="navbar-brand" href="#"><img src="iconos/segared.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse menuInicio" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="#">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Inicio de Sesión</a>
              </li>
            </ul>
          </div>
          <a class="nav-link salida" href="#"><img src="iconos/salida.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        </nav>
        <!-- <nav class="navbar navbar-light bg-light iconoInicio">
          <a class="navbar-brand" href="#"><img src="iconos/segared.png"></a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Iniciar Sesión</a>
              </li>
            </ul>
          </div>
        </nav> -->


        <div id="contenedor">
            <div id="central">
                <div id="login">
                    <div class="titulo">
                        <img src="iconos/usuario.png">
                    </div>
                    <br><br>
                    <form id="loginform">
                        <input type="text" name="usuario" id="UsuarioSession" placeholder="Usuario" required>
                        
                        <input type="password" id="passwordSession" placeholder="Contraseña" name="password" required>
                        
                        <button type="submit" title="Ingresar" name="Ingresar">Ingresar</button>
                    </form>
                    <div class="pie-form">
                        <!-- <a href="#">¿Perdiste tu contraseña?</a> -->
                        <a href="#">¿No tienes Cuenta? Registrate</a>
                    </div>
                </div>
                <div class="inferior">
                    <!-- <a href="#">Volver</a> -->
                </div>
            </div>
        </div>
            
    </body>
</html>
<?php
require_once("message_overlay.php");
?>
<script>
function iniciarSesion(){

    var nombresInicio       = $("#UsuarioSession").val();
    var passwordSession     = $("#passwordSession").val();
}
</script>