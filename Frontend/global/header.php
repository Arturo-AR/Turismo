<?php
  require_once("../global/library.php");
  // $tipoUsuario = $_SESSION['idTipoUsuario'];
  // $idUsuario   = $_SESSION['idUsuario'];
  // $idCiudad   = $_SESSION['idCiudad'];
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Exploring</title>
    <link rel="icon" type="image/x-icon" href="#" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/style.css" rel="stylesheet" />

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/message_overlay.js"></script>
    <script src="../js/utilidades.js"></script>
    <script src="../js/validaciones.js"></script>
    <script src="../js/md5.js"></script>

  </head>
  <body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="../">Exploring</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto">
            <!-- <li class="nav-item"><a class="nav-link" href="#about">Usuarios</a></li> -->
            <li class="nav-item dropdown">
              <a class="nav-link menu dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Alta Usuarios</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Lugares</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <div class="cuerpoPrincipal">
    
    